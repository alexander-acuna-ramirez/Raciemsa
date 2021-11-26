<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Catalog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    {
        $validated = $request->validate( [
            'ID_Catalogo' => 'required|max:8|min:8|alpha_num',
              'Ubicacion' => 'required|digits:4|numeric',
          ]);
                
            DB::select("call sp_update_catalog('" . $validated['ID_Catalogo'] . "','"
            . $validated['Ubicacion'] . "')");
  
        
    
        return redirect('/catalog');
        //return response()->json(["msg"=>"Something new"]);
    }

    public function destroy($id)
    {
       
        $data = DB::select("call sp_delete_catalog('".$id."')");
        return redirect('/catalog');
    }

 
}

