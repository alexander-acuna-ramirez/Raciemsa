<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class SupplierController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $datos=DB::select('call sp_Mostrar_proveedor()');
       // $datos = Supplier::where('Estado_proveedor',1)->orderBy("Codigo_proveedor","DESC")->paginate(5);
        return view('supplier.index',compact('datos'));
    }

    public function create()
    {
        $now=Carbon::now();
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        try{

            DB::select("call sp_ultimo_proveedor(@id)");
            $lastProv = DB::select("select @id as lastProv");
            $calculated = strval(intval($lastProv[0]->lastProv) + 1);
            $calculated = str_repeat("0",10 - strlen($calculated)).$calculated;
            DB::select("call sp_insertar_proveedor(?,?,?)",array($calculated,$request->Razon_social,$request->RUC));

            foreach($request->correos as $correo){
                DB::select("call sp_ultimo_correo(@id)");
                $lastCor = DB::select("select @id as lastCor");
                $lastCor = $lastCor[0]->lastCor;
                $lastCor = substr($lastCor,1);
                $lastCor = strval(intval($lastCor) + 1);
                $lastCor = "C".str_repeat("0",4-strlen($lastCor)).$lastCor;
                DB::select("call sp_insertar_correo(?,?,?)",array($calculated,$lastCor,$correo));
            }

            foreach($request->direcciones as $direccion){
                DB::select("call sp_ultimo_direccion(@id)");
                $lastDir = DB::select("select @id as lastDir");
                $lastDir = $lastDir[0]->lastDir;
                $lastDir = substr($lastDir,1);
                $lastDir = strval(intval($lastDir) + 1);
                $lastDir = "D".str_repeat("0",4-strlen($lastDir)).$lastDir;
                DB::select("call sp_insertar_direccion(?,?,?)",array($calculated,$lastDir,$direccion));
            }

            foreach($request->telefonos as $telefono){
                DB::select("call sp_ultimo_telefono(@id)");
                $lastTel = DB::select("select @id as lastTel");
                $lastTel = $lastTel[0]->lastTel;
                $lastTel = substr($lastTel,1);
                $lastTel = strval(intval($lastTel) + 1);
                $lastTel = "T".str_repeat("0",4-strlen($lastTel)).$lastTel;
                DB::select("call sp_insertar_telefono(?,?,?)",array($calculated,$lastTel,$telefono));
            }
            return response()->json(['status'=>'OK']);
        }catch(\Exception $e){
            return response()->json(['status'=>'BAD','msg'=>$e->getMessage()]);
        }
        
    } 
    
    private function calculateID(){
        //$last = Supplier::select('Codigo_proveedor') ->orderBy("Codigo_proveedor","DESC")-> get()->first();
        $codProv=("call NuevoCodigoProveedor()");
        return response()->json($codProv);
    }

    public function show($id)
    {
        
        $supplier = Supplier::findOrFail($id);
        $phones = DB::select("call sp_obtener_telefono('".$id."')");
        $addresses = DB::select("call sp_obtener_direccion('".$id."')");
        $emails = DB::select("call sp_obtener_correo('".$id."')");
        return view('supplier.show')
            ->with(compact('supplier'))
            ->with(compact('phones'))
            ->with(compact('addresses'))
            ->with(compact('emails'));
        //return response()->json(compact('emails'));
    }
    
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $phones = DB::select("call sp_obtener_telefono('".$id."')");
        $addresses = DB::select("call sp_obtener_direccion('".$id."')");
        $emails = DB::select("call sp_obtener_correo('".$id."')");
        return view('supplier.edit')
            ->with(compact('supplier'))
            ->with(compact('phones'))
            ->with(compact('addresses'))
            ->with(compact('emails'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    public function updateContact(Request $request){
        try{
            /*----------------------------Actualizacion y insercion----------------------------------------------------*/
            $dataCorreos = $request->data['correos'];
            $dataTelefonos = $request->data['telefonos'];
            $dataDirecciones = $request->data['direcciones'];
            foreach($dataCorreos as $correo){
                if($correo['Id_correo'] == ""){
                    DB::select("call sp_ultimo_correo(@id)");
                    $lastCor = DB::select("select @id as lastCor");
                    $lastCor = $lastCor[0]->lastCor;
                    $lastCor = substr($lastCor,1);
                    $lastCor = strval(intval($lastCor) + 1);
                    $lastCor = "C".str_repeat("0",4-strlen($lastCor)).$lastCor;
                    DB::select("call sp_insertar_correo(?,?,?)",array($request->prov,$lastCor,$correo['Correo']));
                }else{
                    DB::select("call sp_update_correo(?,?,?)",array($request->prov,$correo['Id_correo'],$correo['Correo']));
                }
            }
            foreach($dataDirecciones as $direccion){
                if($direccion['Id_direccion'] == ""){
                    DB::select("call sp_ultimo_direccion(@id)");
                    $lastDir = DB::select("select @id as lastDir");
                    $lastDir = $lastDir[0]->lastDir;
                    $lastDir = substr($lastDir,1);
                    $lastDir = strval(intval($lastDir) + 1);
                    $lastDir = "D".str_repeat("0",4-strlen($lastDir)).$lastDir;
                    DB::select("call sp_insertar_direccion(?,?,?)",array($request->prov,$lastDir,$direccion['Direccion']));
                }else{
                    DB::select("call sp_update_direccion(?,?,?)",array($request->prov,$direccion['Id_direccion'],$direccion['Direccion']));
                }
            }
            foreach($dataTelefonos as $telefono){
                if($telefono['Id_telefono'] == ""){
                    DB::select("call sp_ultimo_telefono(@id)");
                    $lastTel = DB::select("select @id as lastTel");
                    $lastTel = $lastTel[0]->lastTel;
                    $lastTel = substr($lastTel,1);
                    $lastTel = strval(intval($lastTel) + 1);
                    $lastTel = "T".str_repeat("0",4-strlen($lastTel)).$lastTel;
                    DB::select("call sp_insertar_telefono(?,?,?)",array($request->prov,$lastTel,$telefono['Telefono']));
                }else{
                    DB::select("call sp_update_telefono(?,?,?)",array($request->prov,$telefono['Id_telefono'],$telefono['Telefono']));
                }
            }
            /*----------------------------Eliminacion----------------------------------------------------*/

            $deleteCorreos = $request->delete['correos'];
            $deleteTelefonos = $request->delete['telefonos'];
            $deleteDirecciones = $request->delete['direcciones'];
            foreach($deleteCorreos as $correo){
                DB::select("call sp_delete_correo(?,?)",array($request->prov,$correo['Id_correo']));
            }
            foreach($deleteTelefonos as $telefono){
                DB::select("call sp_delete_telefonos(?,?)",array($request->prov,$telefono['Id_telefono']));
            }
            foreach($deleteDirecciones as $direccion){
                DB::select("call sp_delete_direccion(?,?)",array($request->prov,$direccion['Id_direccion']));
            }
            return response()->json(['status'=>'OK']);
        }catch(\Exception $e){
            return response()->json(['status'=>'Bad','msg'=>$e->getMessage()]);
        }
    }
    public function destroy($Id)
    {
        try{
            $supplier = DB::select("call sp_eliminar_proveedor('".$Id."')");
            return redirect()->route('supplier.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('supplier.index')->with('Eliminar','Bad');
        }
    }
   public function reportsSuppliers(){
        $reportData = DB::select("call sp_generar_entradas_reporte()");
        $pdf = PDF::loadView('Supplier.reports',compact('reportData'))->setPaper('a5', 'landscape');
        return $pdf->download('reporte.pdf');
   }

     public function forProv(){
        return view('supplier.entriesFor');
    }
    public function forProvData(Request $request){
        $reportData = DB::select("call sp_generar_entradas_por_proveedor(".$request->codProv.")");
        return response()->json($reportData);
        //return response()->json($request);
    }
    public function forProvDataPDF(Request $request){
        $reportData = DB::select("call sp_generar_entradas_por_proveedor(".$request->codProv.")");
        $pdf = PDF::loadView('Supplier.entriesForPDF',compact('reportData'));
        return $pdf->download('reporte.pdf');
    }

    public function searchSupplier(Request $request)
    {
        $cod=$_GET['Buscarpor'];
        $datos = DB::select("call sp_buscar_proveedor_por_codigo('".$cod."')");
        return view('supplier.codeSearch')->with(compact('datos'));
    }

  
    public function SupplierRequestDisabled()
    {
        $datos = DB::select("call sp_mostrar_proveedores_deshabilitados()");
        return view('supplier.SupplierdisabledRequest')->with(compact('datos'));
    }
    
    public function supplierSearchByRUC(Request $request){
        $datos = DB::select("call sp_buscar_proveedor_ruc(?)",array($request->ruc));
        return response()->json(['tam'=>sizeof($datos) ]);
    }
    public function supplierSearchByName(Request $request){
        $datos = DB::select("call sp_buscar_proveedor_nombre(?)",array($request->name));
        return response()->json(['tam'=>sizeof($datos) ]);
    }
   /*public function searchEmail($code){
        
        $data = DB::table('correos')
                ->select('correos.Id_correo',
                    'correos.Correo')
                ->join('proveedor','proveedor.Codigo_proveedor','=','correos.Codigo_proveedor')

                ->where('correos.Id_correo','=',$code)
                ->get();
        return response()->json($data);

    }
    public function searchAddress($code){
        
        $data = DB::table('direcciones')
                ->select('direcciones.Id_direccion',
                    'direcciones.Direccion')
                ->join('proveedor','proveedor.Codigo_proveedor','=','direcciones.Codigo_proveedor')

                ->where('direcciones.Id_direccion','=',$code)
                ->get();
        return response()->json($data);

    }
    public function searchPhone($code){
        
        $data = DB::table('telefono')
                ->select('telefono.Id_telefono',
                    'telefono.Telefono')
                ->join('proveedor','proveedor.Codigo_proveedor','=','telefono.Codigo_proveedor')

                ->where('telefono.Id_telefono','=',$code)
                ->get();
        return response()->json($data);

    }*/
}
