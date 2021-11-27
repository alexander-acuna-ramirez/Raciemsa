<?php

namespace App\Http\Controllers;

use App\Models\EntryVoucher;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntryVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$datos = DB::select(DB::raw('CALL sp_obtener_entradas()'))->paginate(5);
        $datos = EntryVoucher::where('Activo',1)->orderBy("ID_vale_entrada","DESC")->paginate(5);
        return view('entryvoucher.index',compact('datos'));
    }


    public function create()
    {
        return view('entryvoucher.create')
                ->with('date',date("Y-m-d"))
                ->with('time',date("H:i"));
    }


    public function store(Request $request)
    {
        DB::select("call sp_obtener_ultimo_codigo(@id)");
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
        }
    }

    public function show($id)
    {
        $voucher = EntryVoucher::findOrFail($id);
        $entries = DB::select("call sp_obtener_entradas('".$id."')");
        return view('entryvoucher.show')
            ->with(compact('voucher'))
            ->with(compact('entries'));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, EntryVoucher $entryVoucher)
    {
        //
    }

    public function destroy($Id)
    {
        try{
            $entries = DB::select("call sp_eliminar_vales_entradas('".$Id."')");
            return redirect()->route('entryvoucher.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('entryvoucher.index')->with('Eliminar','Bad');
        }

    }

    public function reportEntries()
    {
        return view('entryvoucher.report');
    }
    public function reportEntriesSearch(Request $request)
    {
        $entries = DB::select("call sp_report_search_vales_entrada(?,?)",array($request->from,$request->to));
        return response()->json($entries);
    }
    public function reportEntriesPDF(Request $request)
    {
        $entries = DB::select("call sp_report_search_vales_entrada(?,?)",array($request->from,$request->to));
        $pdf = PDF::loadView('entryvoucher.reportpdf',['curdate'=>date("Y-m-d"),'entries'=>$entries,'hora'=> date("H:i"),'to'=>$request->to,'from'=>$request->from]);
        return $pdf->download('reporte.pdf');
    }

    public function searchGuide($code){
        $data = DB::select("call sp_buscar_guia('".$code."')");
        return response()->json($data);
    }

    public function searchProduct($code){

        $data = DB::select("call sp_search_product('".$code."')");
        return response()->json($data);
    }
    public function entriesDeleted(){
        $datos = DB::select("call sp_obtener_entradas_desactivadas()");
        return view('entryvoucher.disabled')->with(compact('datos'));
    }
    public function searchEntryVoucherProv(Request $request){

        $datos = DB::select("call sp_buscador_vale('P',?,NULL,NULL)",array($request->searchfor));
        $msg = "Resultados para ".$request->searchfor;
        return view('entryvoucher.found')
                ->with(compact('datos'))
                ->with(compact('msg'));
        //return response()->json($request->searchfor);
    }
    public function searchEntryVoucherDate(Request $request){

        $datos = DB::select("call sp_buscador_vale('F',NULL,?,?)",array($request->from,$request->to));
        $msg = "Resultados para ".$request->to." - ".$request->from;
        return view('entryvoucher.found')
            ->with(compact('datos'))
            ->with(compact('msg'));
    }
    public function searchLocationsEntries($id){
        $datos = DB::select("Call sp_buscador_ubicaciones_entradas(?)",array($id));
        return response()->json($datos);
    }
    public function entryVoucherToday(){
        DB::select("call sp_vale_entrada_hoy(@cant)");
        $cantEntries = DB::select('select @cant as cant');
        return response($cantEntries[0]->cant);
    }
    public function entryVoucherPDF($id){
        $voucher = EntryVoucher::findOrFail($id);
        $entries = DB::select("call sp_obtener_entradas('".$id."')");
        $pdf = PDF::loadView('entryvoucher.pdf',['voucher'=>$voucher,'entries'=>$entries])->setPaper('a5', 'landscape');
        return $pdf->download('ValeDeEntrada '.$id.'.pdf');
    }
    public function chartEntryMonth(){
        $stats = DB::select("call sp_entradas_mensuales()");
        return response()->json($stats);
    }

    //Pasar a materiales
    public function chartDonutTopMaterials(){
        $data = DB::select("call sp_top_materiales()");
        return response()->json($data);
    }
}
