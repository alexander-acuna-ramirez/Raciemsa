<?php

namespace App\Http\Controllers;


use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use Barryvdh\DomPDF\Facade as PDF;

class GuideController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        /* $datos = Guide::orderBy('Codigo_guia_remision',"DESC")
        ->where('Estado','=','1')->paginate(5); */
        $datos = DB::select("call sp_mostrar_guias_validas()");

        /* Procedimiento almacenado para filtrar por código */
        //$datos=DB::select(" call sp_buscar_guia_valida_por_codigo('" . $guia . "')");

        return view('guide.index',compact('datos'));
    }

    public function disableGuides()
    {
        /* Procedimiento almacenado para filtrar por código */
        $datos = DB::select(" call sp_mostrar_guias_deshabilitadas()");

        return view('guide.disable',compact('datos'));
    }

    public function searchGuide()
    {
        $guia=$_GET['searchfor'];

        /* Procedimiento almacenado para filtrar por código */
        $datos=DB::select(" call sp_buscar_guia_valida_por_codigo('" . $guia . "')");

        return view('guide.search')->with(compact('datos'));
    }

    public function searchGuideDisable()
    {
        $guia=$_GET['search'];

        /* Procedimiento almacenado para filtrar por código */
        $datos=DB::select(" call sp_buscar_guia_invalida_por_codigo('" . $guia . "')");

        return view('guide.searchDisable')->with(compact('datos'));
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

        /* Llamado a procedimiento almacenado para filtrar por fechas */
        $datos = DB::select("call sp_buscar_guia_valida_por_fecha('" . $from . "','" . $to . "')");

        return view('guide.searchDate')->with(compact('datos'));
    }

    public function searchbyDateDisable(Request $request)
    {
        $from=$request->get('fromDate');
        $to=$request->get('toDate');

        if ($from==NULL) {
            $from='1500-01-01';
        }
        if ($to==NULL) {
            $to='3000-01-01';
        }

        /* Llamado a procedimiento almacenado para filtrar por fechas */
        $datos = DB::select("call sp_buscar_guia_invalida_por_fecha('" . $from . "','" . $to . "')");

        return view('guide.searchDateDisable')->with(compact('datos'));
    }

    public function create()
    {
        $prov=DB::table('proveedor')
        ->select('Codigo_proveedor','Razon_social')
        ->get();

        return view('guide.create')->with(compact('prov'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Codigo_guia_remision' => 'required|max:14|min:14|unique:Guia_de_remision',
            'Fecha_de_emision' => 'required|before:now',
            'Inicio_traslado' => 'required|after:Fecha_de_emision',
            'Fin_traslado' => 'required|after:Inicio_traslado',
            'Codigo_proveedor' => 'required|min:10|max:10',
        ]);
        $data = $request->except("_token");

        /* Llamado a procedimiento almacenado para la inserción */
        DB::select("call sp_insertar_guia('" . $validated['Codigo_guia_remision'] . "','"
            . $validated['Fecha_de_emision'] . "','" . $validated['Inicio_traslado'] . "','"
            . $validated['Fin_traslado'] . "','" . $validated['Codigo_proveedor'] . "')");
        
        return redirect('/guide');
    }

    public function show(Guide $guide)
    {
        //
    }

    public function edit(Guide $guide)
    {
        $prov=DB::table('proveedor')
        ->select('Codigo_proveedor','Razon_social')
        ->get();
        return view('guide.edit',compact('guide'))->with(compact('prov'));
    }

    public function update(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'Codigo_guia_remision' => 'required|max:14|min:14',
            'Fecha_de_emision' => 'required|before:now',
            'Inicio_traslado' => 'required|after:Fecha_de_emision',
            'Fin_traslado' => 'required|after:Inicio_traslado',
            'Codigo_proveedor' => 'required|min:10|max:10|exists:Proveedor,Codigo_proveedor',
        ]);
        DB::select("call sp_editar_guia_de_remision('" . $validated['Codigo_guia_remision'] . "','"
            . $validated['Fecha_de_emision'] . "','" . $validated['Inicio_traslado'] . "','"
            . $validated['Fin_traslado'] . "','" . $validated['Codigo_proveedor'] . "')");
        return redirect('/guide');
    }

    public function destroy($id)
    {
        try{
            $entries = DB::select("call sp_eliminar_guia_de_remision('".$id."')");
            return redirect()->route('guide.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('guide.index');
        }
    }

    public function searchProveedor($code)
    {
        /* Llamado a procedimiento almacenado para mostrar proveedor */
        $data = DB::select("call sp_obtener_proveedor('".$code."')");

        return response()->json($data);

    }

    public function report(Request $request)
    {

        return view('guide.report');

    }

    public function downloadPDF(Request $request)
    {
        $emiDate=$request->get('FecEmis');
        $codGuia=$request->get('CodGuia');

        if ($emiDate == null) {
            $datos = DB::select(" call sp_reporte_guias_materiales_mostrar('" . $codGuia . "')");
        } else{
            $datos = DB::select(" call sp_reporte_guias_materiales('" . $codGuia . "','" . $emiDate . "')");
        }
        
        $pdf = PDF::loadView('guide.pdf',['datos'=>$datos]);
        return $pdf->download('guiaRemision.pdf');

    }

    public function downloadPDFall()
    {
        $datos = DB::select(" call sp_reporte_guias_con_proveedor()");
                
        $pdf = PDF::loadView('guide.allpdf',['datos'=>$datos]);
        return $pdf->download('guiaRemisionTotal.pdf');

    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
