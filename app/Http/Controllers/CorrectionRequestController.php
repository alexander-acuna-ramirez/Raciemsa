<?php

namespace App\Http\Controllers;

use App\Models\CorrectionRequest;
use App\Models\Corrections;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class CorrectionRequestController extends Controller
{
    public function __construct(){}

    public function index(Request $request)
    {
        $cod=$request->get('Buscarpor');
        $datos = DB::select("call mostrar_solicitudes_habilitadas()");        
        return view('CorrectionRequest.index',compact('datos'));    
    }

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
        $cad = "SC";
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 6 ? str_repeat("0",6 - strlen($calculated)).$calculated : $calculated;
        $conc=$cad.$calculated;
        try{            
            DB::select("call insertar_Solicitud_correccion('".$conc."', 
            '".$request->Codigo_reposicion."','".$request->Codigo_guia_remision."',
            '".$request->Motivo."','".$request->Fecha."')");
            foreach ($request->Correcciones as $correccion) {
                DB::select("call insertar_Solicitud_correccion(?,?,?)", array($conc,$correccion['Numero_de_parte'],$correccion['Diferencia'],));
            }
            $datos = DB::select("call mostrar_solicitudes_habilitadas()");        
            return view('CorrectionRequest.index',compact('datos'));
        }catch (\Exception $e){
            $datos = DB::select("call mostrar_solicitudes_habilitadas()");    
            //return response()->json($e->getMessage(),500);    
            return view('CorrectionRequest.index',compact('datos'));
        }
    }

    public function show($id)
    {
        $solicitud=CorrectionRequest::findOrFail($id);
        $correcciones = DB::select("call correcciones_de_solicitud('".$id."')");
        return view('CorrectionRequest.show')
            ->with(compact('correcciones'))
            ->with(compact('solicitud'));
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

    public function totalCorrectionRequest(){
        DB::select("call solicitud_correccion_total(@total)");
        $convert = DB::select('select @total as last');
        return response()->json($convert);
    }

    public function reportCorrections()
    {
        $datos = DB::select("call mostrar_solicitudes_detalles_proveedor()");
        $pdf = PDF::loadView('CorrectionRequest.reportSC',['datos'=>$datos]);
        return $pdf->download('SolicitudCorreccion.pdf');
    }

    public function CorrectionRequestPDF($id){
        $request = CorrectionRequest::findOrFail($id);
        $corrections = DB::select("call mostrar_correcciones_detalles('".$id."')");
        $pdf = PDF::loadView('CorrectionRequest.pdf',['request'=>$request,'corrections'=>$corrections])->setPaper('a5', 'landscape');
        return $pdf->download('vale.pdf');
    }
}
