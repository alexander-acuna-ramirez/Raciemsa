<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Catalog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

use Response;
class CatalogController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
       $buscadorM=$request->get('buscarCatalog');
       $nuevoCodigo=DB::select("call sp_generar_codigo_catalogo()");
        $datos=DB::select("CALL sp_listar_catalog_id ('".$buscadorM."')");
        //return response()->json(["msg"=>$nuevoCodigo]);
        
        return view('catalog.index',compact('nuevoCodigo'))->with('datos',$datos);
       // return view('catalog.index',compact('datosM','datos'))->with("Next",$this->calculateID());
    }



    public function create()
    {
        $nuevoCodigo=DB::select("call sp_generar_codigo_catalogo()");
        return view('catalog.createcatalog',compact('nuevoCodigo'));
    }

    public function store(Request $request)
    { //return response()->json(["msg"=>"CALL sp_insert_catalog ('".$ID_Catalogo."','".$Ubicacion."') ;"]);
        //return $request->ID_Catalogo;
        $validated = $request->validate( [
          'ID_Catalogo' => 'required|max:8|min:8|alpha_num',
            'Ubicacion' => 'required|digits:4|numeric',
        ]);
             DB::select("CALL sp_insert_catalog ('".$validated['ID_Catalogo']."','".$validated['Ubicacion']."') ;");
        
            return redirect('/catalog');

        
   
    }

    

    public function show(Catalog $catalog)
    {
        return response()->json($catalog);
    }

    
    
    public function edit(Catalog $catalog)
    {
        //return response()->json(["msg"=>$catalog]);
        return view('catalog.editcatalog',compact('catalog'));
    }


    public function update(Request $request, Catalog $catalog)
    { $ID_Catalogo=$catalog->ID_Catalogo;
        //dd($ID_Catalogo);
        $validated = $request->validate( [
              'Ubicacion' => 'required|digits:4|numeric',
          ]);
            DB::select("call sp_update_catalog('" . $ID_Catalogo . "','"
            . $validated['Ubicacion'] . "')");
       
    
        return redirect('/catalog');
        //return response()->json(["msg"=>"Something new"]);
    }

    public function destroy($id)
    {
       
        $data = DB::select("call sp_delete_catalog('".$id."')");
        return redirect('/catalog');
    }
    
    public function reportCatalogPDF($id)
    {
        $listCat= DB::select("call sp_listar_catalog_id('$id')");
        $materiales= DB::select("call sp_materiales_id_catalog('$id')");
        $datos = compact('listCat','materiales');
        $pdf = PDF::loadView('catalog.reportPDF',$datos)->setPaper('a4', 'landscape');;
        return $pdf->download('Reporte de Catalogo '.$id.'.pdf');
    }
    public function reporteValorizado()
    {
        $fecha=date("Y-m-d");
        $listCat= DB::select("call sp_report_valorizado()");
        $datos = compact('listCat');
        $pdf = PDF::loadView('catalog.reporteValorizado',$datos)->setPaper('a4', 'landscape');;
        return $pdf->download('CatalogoValorizado '.$fecha.'.pdf');
    }
    public function delete($id, Request $request)
    {  
        try{
            $data = DB::select("call sp_delete_catalog('$id')");
            return response()->json(['status'=>1,'success'  => $id]);

        }catch(\Exception $e){
            return response()->json(['status'=>0,'error'  => $e]);
        }
    }
 
}

