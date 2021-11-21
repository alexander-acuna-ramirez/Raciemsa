<?php

namespace App\Http\Controllers;

use App\Models\EntryVoucher;
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
        DB::select("call sv_obtener_ultimo_codigo(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 8 ? str_repeat("0",8 - strlen($calculated)).$calculated : $calculated;
        try{

            $cabecera = new EntryVoucher();
            $cabecera->ID_vale_entrada = $calculated;
            $cabecera->Codigo_guia_remision = $request->Codigo_guia_remision;
            $cabecera->Hora = $request->Hora;
            $cabecera->Fecha_recepcion = $request->Fecha;

            $cabecera->save();

            foreach ($request->Entradas as $entrada) {
                DB::table('entradas')->insert([
                    "ID_vale_entrada"=>$calculated,
                    "Numero_de_parte"=>$entrada['Numero_de_parte'],
                    "Cantidad_recibida"=>$entrada['Cantidad'],
                    "Observacion"=>$entrada['Observacion'],
                    "Status"=>$entrada['Status'] == true ? 1 : 0,
                ]);
            }

            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    public function show($id)
    {
        $voucher = EntryVoucher::findOrFail($id);
        $entries = DB::select("call sv_obtener_entradas('".$id."')");
        return view('entryvoucher.show')
            ->with(compact('voucher'))
            ->with(compact('entries'));
    }


    public function edit(EntryVoucher $entryVoucher)
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

    public function saveEntries(Request $request){

        /*
        DB::select("call sv_obtener_ultimo_codigo(@id)");
        $convert = DB::select('select @id as last');
        $calculated = strval(intval($convert[0]->last) + 1);
        $calculated = strlen($calculated) < 8 ? str_repeat("0",8 - strlen($calculated)).$calculated : $calculated;
        try{

            $cabecera = new EntryVoucher();
            $cabecera->ID_vale_entrada = $calculated;
            $cabecera->Codigo_guia_remision = $request->Codigo_guia_remision;
            $cabecera->Hora = $request->Hora;
            $cabecera->Fecha_recepcion = $request->Fecha;

            $cabecera->save();

            foreach ($request->Entradas as $entrada) {
                DB::table('entradas')->insert([
                    "ID_vale_entrada"=>$calculated,
                    "Numero_de_parte"=>$entrada['Numero_de_parte'],
                    "Cantidad_recibida"=>$entrada['Cantidad'],
                    "Observacion"=>$entrada['Observacion'],
                    "Status"=>$entrada['Status'] == true ? 1 : 0,
                ]);
            }

            return response()->json(["msg"=>"Ok"],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }*/
    }


    /*CONVERTIR A PROCEDIMIENTO*/
    public function searchGuide($code){
        /*return response()->json(['msg'=>$code]);*/
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
        /*return response()->json(['msg'=>$code]);*/

        $data = DB::table('Material')
            ->select('Numero_de_parte',
                'Descripcion',
                'Unidad_de_medida',
                'Codigo_sap')
            ->where('Numero_de_parte','=',$code)
            ->get();
        return response()->json($data);
    }

}
