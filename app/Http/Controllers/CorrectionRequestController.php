<?php

namespace App\Http\Controllers;

use App\Models\CorrectionRequest;
use App\Models\Corrections;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use DB;

class CorrectionRequestController extends Controller
{
    public function __construct(){}

    public function index(Request $request)
    {
        $cod=$request->get('Buscarpor');
        $datos = DB::select("call mostrar_solicitudes_habilitadas()");        
        return view('CorrectionRequest.index',compact('datos'));
    
    }
    /*public function showCorrections($codigo)
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
    }*/

    public function create()
    {
        $now=Carbon::now();
        $currentDate=$now->format('Y-m-d');
        return view('CorrectionRequest.create')
            ->with(compact("currentDate"));
    }

    public function store(Request $request)
    {
        $now=Carbon::now();

        DB::select("call obtener_ultimo_codigo(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 8 ? str_repeat("0",8 - strlen($calculated)).$calculated : $calculated;
        //$calculated=DB::select("call generar_codigo_solicitud_correccion()");
        try{

            $cabecera = new CorrectionRequest();
            $cabecera->Codigo_solicitud_correccion = $calculated;
            $cabecera->Codigo_reposicion = $request->Codigo_reposicion;
            $cabecera->Codigo_guia_remision = $request->Codigo_guia_remision;
            $cabecera->Motivo = $request->Motivo;
            $cabecera->Fecha = $request->Fecha;
            $cabecera->Status= $request->Status;
            $cabecera->save();
            
            //$cabecera=DB::select("call insertar_Solicitud_correccion('".$calculated."', 
            //'".$request->Codigo_reposicion."','".$request->Codigo_guia_remision."',
            //'".$request->Motivo."','".$request->Fecha."', '".$request->Status."')");
            
            //insertar_Solicitud_correccion(in CodigoSC CHAR(8), in CodigoR CHAR(6), 
            //in CodigoGR CHAR(14), in Motive VARCHAR(55), in FechaSC Date)

            foreach ($request->Correcciones as $correccion) {
                DB::table('correcciones')->insert([
                    "Codigo_solicitud_correccion"=>$calculated,
                    "Numero_de_parte"=>$correccion['Numero_de_parte'],
                    "Diferencia"=>$correccion['Diferencia'],                                       
                ]);
                
                //$corrections=BD::select(" call insertar_correcciones('".$calculated."',
                //'".$correccion['Numero_de_parte']."','".$correccion['Diferencia']."')")

            }
            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }

        /*DB::select("call obtener_ultimo_codigo(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 8 ? str_repeat("0",8 - strlen($calculated)).$calculated : $calculated;
        try{
            //GUARDANDO CABECERA
            DB::select("call sp_guardar_cabecera_entrada('".$calculated."','".$request->Codigo_guia_remision."','".$request->Hora."','".$request->Fecha."')");
            foreach ($request->Entradas as $entrada) {
                DB::select("call sp_guardar_cuerpo_vale_entrada(?,?,?,?,?)", array($calculated,$entrada['Numero_de_parte'],$entrada['Cantidad'],$entrada['Observacion'],$entrada['Status'] == true ? 1 : 0,));
            }
            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }*/
    }

    private function calculateCodigo(){
        $codSC=("call generar_codigo_solicitud_correccion()");
        return response()->json($codSC);
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
        $data = DB::select("call buscar_guia_remision('".$code."')");
        return response()->json($data);

    }
    public function searchProduct($code){
        $data = DB::select("call buscar_producto('".$code."')");
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
        $datos = DB::select("call mostrar_solicitudes_deshabilitadas()");
        return view('CorrectionRequest.disabledRequest')->with(compact('datos'));
    }
}
