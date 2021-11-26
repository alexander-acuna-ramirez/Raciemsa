<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;

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
        $now=Carbon::now();

        DB::select("call Ultimo_proveedor(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 10 ? str_repeat("0",10 - strlen($calculated)).$calculated : $calculated;

        try{

            $cabecera = new Supplier();
            $cabecera->Codigo_proveedor = $calculated;
            $cabecera->Razon_social = $request->Razon_social;
            $cabecera->RUC = $request->RUC;
            $cabecera->save();

            DB::select("call Ultimo_telefono(@id)");
            $convertPhone = DB::select('select @id as last');
            $calculatedPhone = strval(intval($convertPhone[0]->last) + 1);
            $calculatedPhone = strlen($calculatedPhone) < 5 ? str_repeat("0",5 - strlen($calculatedPhone)).$calculatedPhone: $calculatedPhone;
            
           /* $cabeceraPhone = new Phone();
            $cabeceraPhone -> Codigo_proveedor = $convert;
            $cabeceraPhone->Id_telefono = $calculatedPhone;
            $cabeceraPhone->Telefono = $request->Telefono;
            $cabeceraPhone->save();*/
            

            DB::select("call Ultimimo_direccion(@id)");
            $convertAddress = DB::select('select @id as last');
            $calculatedAddress = strval(intval($convertAddress[0]->last) + 1);
            $calculatedAddress = strlen($calculatedAddress) < 5 ? str_repeat("0",5 - strlen($calculatedAddress)).$calculatedAddress: $calculatedAddress;
            
            /*$cabeceraAddress = new Address();
            $cabeceraAddress -> Codigo_proveedor = $convert;
            $cabeceraAddress->Id_direccion = $calculatedAddress;
            $cabeceraAddress->Direccion = $request->Direccion;
            $cabeceraAddress->save();*/

            DB::select("call Ultimo_correo(@id)");
            $convertEmail = DB::select('select @id as last');
            $calculatedEmail = strval(intval($convertEmail[0]->last) + 1);
            $calculatedEmail = strlen($calculatedEmail) < 5 ? str_repeat("0",5 - strlen($calculatedEmail)).$calculatedEmail: $calculatedEmail;
            
            /*$cabeceraEmail = new Email();
            $cabeceraEmail -> Codigo_proveedor = $convert;
            $cabeceraEmail->Id_correo = $calculatedEmail;
            $cabeceraEmail->Correo = $request->Correo;
            $cabeceraEmail->save();*/

            foreach ($request-> Ttelefono as $telefono) {
                DB::table('telefono')->insert([
                    "Id_telefono"=>$calculatedPhone,
                    "Telefono"=>$telefono['Telefono'],
                ]);
            }
            foreach ($request-> Ccorreo as $correos) {
                DB::table('telefono')->insert([
                    "Id_telefono"=>$calculatedEmail,
                    "Correo"=>$correos['Telefono'],
                ]);
            }
            foreach ($request->Ddireccion as $direcciones) {
                DB::table('telefono')->insert([
                    "Id_telefono"=>$calculatedAddress,
                    "Direccion"=>$direcciones['Telefono'],
                ]);
            }
            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    } 
    

    /*Convertir a procedimiento almacenado*/
    private function calculateID(){
        //$last = Supplier::select('Codigo_proveedor') ->orderBy("Codigo_proveedor","DESC")-> get()->first();
        $codProv=("call NuevoCodigoProveedor()");
        return response()->json($codProv);
    }

    public function show($id)
    {
        
        $supplier = Supplier::findOrFail($id);
        $phone = DB::select("call obtener_telefono('".$id."')");
        $address = DB::select("call obtener_direccion('".$id."')");
        $email = DB::select("call obtener_correo('".$id."')");
        return view('supplier.show')
            ->with(compact('supplier'))
            ->with(compact('phone'))
            ->with(compact('address'))
            ->with(compact('email'));
    }
    
    public function edit(Supplier $supplier)
    {
        //return response()->json(["msg"=>$catalog]);
        return view('supplier.edit',compact('Supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'Codigo_proveedor' => 'required|max:10|min:10',
            'RUC' => 'required|max:11|min:11',
            'Razon_social' =>'required',
            'Telefono'=> 'required|max:12|min:18',
            'Correo' => 'required',
            'Direccion' => 'required'
        ]);
        $supplier->update($request->except("_token"));
        return redirect('/supplier');
    }

    public function destroy($Id)
    {
        try{
            $supplier = DB::select("call Eliminar_proveedor('".$Id."')");
            return redirect()->route('supplier.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('supplier.index')->with('Eliminar','Bad');
        }
    }
   

    public function searchSupplier(Request $request)
    {
        $cod=$_GET['Buscarpor'];
        $datos = DB::select("call sp_buscar_proveedor_por_codigo('".$cod."')");
        return view('supplier.codeSearch')->with(compact('datos'));
    }

  
    public function SupplierRequestDisabled()
    {
        $datos = DB::select("call mostrar_proveedores_deshabilitados()");
        return view('supplier.SupplierdisabledRequest')->with(compact('datos'));
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
