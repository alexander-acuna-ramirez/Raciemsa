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

}
