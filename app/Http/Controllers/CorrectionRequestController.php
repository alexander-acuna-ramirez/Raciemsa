<?php

namespace App\Http\Controllers;

use App\Models\CorrectionRequest;
use App\Models\Corrections;
use Illuminate\Http\Request;
use DB;

class CorrectionRequestController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(Request $request)
    {
        $cod=$request->get('Buscarpor');
        $datos = DB::select("call mostrar_solicitudes_habilitadas()");
                   
        //$datos = CorrectionRequest::orderBy("Codigo_solicitud_correccion","DESC")
        //    ->where('Codigo_solicitud_correccion','like',"%$cod%")->paginate();
        
        return view('CorrectionRequest.index',compact('datos'));
    
    }
    public function showCorrections($codigo)
    {
        $corrections = DB::table('correcciones')
            ->select('correcciones.Codigo_solicitud_correccion', 
                    'correcciones.Numero_de_parte', 'correcciones.Diferencia')
            ->join('solicitud_de_correccion', 'solicitud_de_correccion.Codigo_solicitud_correccion'
                    ,'=','correcciones.Codigo_solicitud_correccion')
            ->where('correcciones.Codigo_solicitud_correccion','=',$codigo)
            ->get();
        //return response()->json($corrections);
        return view('CorrectionRequest.show') ->with(compact('solicitud'));
        //return redirect()->back();
    }

    public function create()
    {
        return view('CorrectionRequest.create')->with("Next",$this->calculateCodigo());
        //insertar_Solicitud_correccion
    }

    public function store(Request $request)
    {
        /*$request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Codigo_reposicion' => 'required|max:6|min:6|',
            'Codigo_guia_remision' => 'required|max:14|min:14|',
            'Motivo' => 'required|max:100|min:6|',
            'Fecha' => 'required',
            'Status'=> 'required',
        ]);
        $data = $request->except("_token");
        CorrectionRequest::insert($data);
        return redirect('/CorrectionRequest');*/

        DB::select("call obtener_ultimo_codigo(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 8 ? str_repeat("0",8 - strlen($calculated)).$calculated : $calculated;
        try{

            $cabecera = new CorrectionRequest();
            $cabecera->Codigo_solicitud_correccion = $calculated;
            $cabecera->Codigo_reposicion = $request->Codigo_reposicion;
            $cabecera->Codigo_guia_remision = $request->Codigo_guia_remision;
            $cabecera->Motivo = $request->Motivo;
            $cabecera->Fecha = $request->Fecha;
            $cabecera->Status= $request->Status;
            $cabecera->save();

            foreach ($request->Correcciones as $correccion) {
                DB::table('correcciones')->insert([
                    "Codigo_solicitud_correccion"=>$calculated,
                    "Numero_de_parte"=>$correccion['Numero_de_parte'],
                    "Diferencia"=>$correccion['Diferencia'],                                       
                ]);
            }
            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    private function calculateCodigo(){
        $last = CorrectionRequest::select('Codigo_solicitud_correccion')
                ->orderBy("Codigo_solicitud_correccion","DESC")->get()->first();
        $id = (empty($last)) ? "SC000000" : $last["Codigo_solicitud_correccion"];
        $next = strval(intval(substr($id,1,strlen($id))) + 1);
        return "C".str_repeat("0",7-strlen($next)).$next;
    }

    public function show($id)
    {
        $solicitud=CorrectionRequest::findOrFail($id);
        $correcciones = DB::select("call correcciones_de_solicitud('".$id."')");
        return view('CorrectionRequest.show')
            ->with(compact('correcciones'))
            ->with(compact('solicitud'));
    }

    public function edit(CorrectionRequest $CorrectionRequest)
    {

        //$editSC=DB:: DB::select("call correcciones_de_solicitud('".$id."','".$."')");
        return view('CorrectionRequest.edit',compact('CorrectionRequest'));
    }


    public function update(Request $request, CorrectionRequest $CorrectionRequest)
    {
        $request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Codigo_reposicion' => 'required|max:6|min:6|',
            'Codigo_guia_remision' => 'required|max:14|min:14|',
            'Motivo' => 'required|max:100|min:6|',
            'Fecha' => 'required',
            'Status'=> 'required',
        ]);
        $CorrectionRequest->update($request->except("_token"));
        return redirect('/CorrectionRequest');

        //$corrections = DB::select("editarMotivo_Solicitud_correccion('".$id."','".$.Motive."')");
    }

    public function change_status($id)
    {
        try{
            $sc = DB::select("call deshabilitar_Solicitud_Correccion('".$id."')");
            return redirect()->route('CorrectionRequest.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('CorrectionRequest.index');
        }
    }

    public function destroy($id)
    {
        try{
            $corrections = DB::select("call deshabilitar_Solicitud_Correccion('".$id."')");
            return redirect()->route('CorrectionRequest.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('CorrectionRequest.index')->with('Eliminar','Bad');
        }
    }

    public function searchGuide($code){
        $data = DB::table('guia_de_remision')
                ->select('guia_de_remision.Codigo_guia_remision',
                    'guia_de_remision.Fecha_de_emision',
                    'guia_de_remision.Inicio_traslado',
                    'guia_de_remision.Fin_traslado',
                    'Proveedor.Razon_social')
                ->join('Proveedor','Proveedor.Codigo_proveedor','=','guia_de_remision.Codigo_proveedor')

                ->where('guia_de_remision.Codigo_guia_remision','=',$code)
                ->get();
        return response()->json($data);

    }
    public function searchProduct($code){
        $data = DB::table('Material')
            ->select('Numero_de_parte',
                'Descripcion',
                'Unidad_de_medida',
                'Codigo_sap')
            ->where('Numero_de_parte','=',$code)
            ->get();
        return response()->json($data);
    }

    public function searchRequest(Request $request)
    {
        $cod=$request->get('Buscarpor');
        $datos = DB::select("call buscar_solicitud_correccion_por_codigo('".$cod."')");
        return view('CorrectionRequest.codeSearch')->with(compact('datos'));
    }

    public function searchbyDate()
    {
        $from=$_GET['from'];
        $to=$_GET['to'];

        if ($from==NULL) {
            $from='1500-01-01';
        }
        if ($to==NULL) {
            $to='3000-01-01';
        }
        
        $datos = DB::select("call buscar_solicitud_correccion_por_fecha('" . $from . "','" . $to . "')");
        return view('CorrectionRequest.dateSearch')->with(compact('datos'));
    }

    public function disabledCorrectionRequest()
    {
        $datos = DB::select("call mostrar_solicitudes_deshabilitadas");
        return view('CorrectionRequest.disabledRequest')->with(compact('datos'));
    }
}
