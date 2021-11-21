<?php

namespace App\Http\Controllers;


use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $datos = Guide::orderBy('Codigo_guia_remision',"DESC")->paginate(5);
        //$datos = DB::select("call sp_buscar_guia_por_codigo('" . $guia . "')");
        
        return view('guide.index',compact('datos'));
    }

    public function searchGuide()
    {
        $guia=$_GET['searchfor'];
        $datos = Guide::where('Codigo_guia_remision','like',"%$guia%")->paginate(5);
        //$datos = DB::select("call sp_buscar_guia_por_codigo('" . $guia . "')");
        return view('guide.search')->with(compact('datos'));
    }

    public function searchbyDate()
    {
        $from=$_GET['from'];
        $to=$_GET['to'];
        echo "<script>console.log('".$from."');</script>";
        $datos = Guide::whereDate('Fecha_de_emision','>=',$from)
            ->whereDate('Fecha_de_emision','<=',$to)->paginate(5);
        //$datos = DB::select("call sp_buscar_guia_por_codigo('" . $guia . "')");
        return view('guide.searchDate')->with(compact('datos'));
    }

    public function create()
    {
        
        return view('guide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Codigo_guia_remision' => 'required|max:14|min:14',
            'Fecha_de_emision' => 'required',
            'Inicio_traslado' => 'required',
            'Fin_traslado' => 'required',
            'Codigo_proveedor' => 'required',
        ]);
        $data = $request->except("_token");
        Guide::insert($data);
        //return response()->json(["ENVIADOS"=>$request->except("_token")]);
        return redirect('/guide');
    }

    public function show(Guide $guide)
    {
        //
    }

    public function edit(Guide $guide)
    {
        return view('guide.edit',compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'Codigo_guia_remision' => 'required|max:14|min:14',
            'Fecha_de_emision' => 'required',
            'Inicio_traslado' => 'required',
            'Fin_traslado' => 'required',
            'Codigo_proveedor' => 'required',
        ]);
        $guide->update($request->except("_token"));
        return redirect('/guide');
    }

    public function destroy($id)
    {
        /* try{
            $entries = DB::select("call sp_eliminar_guida_de_remision('".$Id."')");
            return redirect()->route('guide.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('guide.index');
        } */
        Guide::destroy($id);
        return redirect('/guide');
    }

    public function searchProveedor($code){
        /*return response()->json(['msg'=>$code]);*/
        $data = DB::table('proveedor')
                ->select('proveedor.Codigo_proveedor',
                    'proveedor.Razon_social',
                    'proveedor.RUC')
                ->where('proveedor.Codigo_proveedor','=',$code)
                ->get();
        return response()->json($data);

    }

    
}
