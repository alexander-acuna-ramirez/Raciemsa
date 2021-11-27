<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Material;

use Illuminate\Support\Facades\DB;
use Response;
use PDF;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function searchMaterialsap()
    {
        $nparte=$_GET['buscarNParte'];
        $sap=$_GET['buscarsap'];
       
        if (isset($_GET['id']) && isset($_GET['buscarNParte'])){      
        $datosM = DB::select("call sp_listar_materiales_SAP('".$sap."','".$_GET['id']."','".$_GET['buscarNParte']."')");
        return view('material.searchSAP')->with('datosM',$datosM)->with('Title',"Materiales filtrados por catálogo");
        }else{
            if (isset($_GET['buscarNParte'])){ 
                $datosM = DB::select("call sp_listar_materiales_SAP('".$sap."','','".$_GET['buscarNParte']."')");
                return view('material.searchSAP')->with('datosM',$datosM)->with('Title',"Materiales filtrados por Número de Parte");
            }else{
            $datosM=DB::select("CALL sp_listar_materiales_SAP ('".$sap."','')");
            return view('material.searchSAP')->with('datosM',$datosM)->with('Title',"Materiales");}
        }
    }

    public function index(Request $request)
    {
      
      
       if (isset($_GET['id'])){
        $datosM=DB::select("CALL sp_listar_materiales_numeroparte ('".$_GET['id']."')");
        return view('material.index')->with('datosM',$datosM)->with('Title',"Materiales filtrados por catalogo");
    }else{
        
        $datosM=DB::select("CALL sp_listar_materiales_numeroparte ('')");
        return view('material.index')->with('datosM',$datosM)->with('Title',"Materiales");
    }
       
       
      

        //
       // return view('catalog.index',compact('datosM','datos'))->with("Next",$this->calculateID());
    }
    public function create()
    {
        $data = DB::select("call sp_listar_catalog_id ('')");
        return view('material.create')->with(compact('data'));;
    }
    
  
    
    public function storeMaterial(Request $request)
    {//return response()->json(["ENVIADOS"=>$request->except("_token")]);
        $validated = $request->validate([
            'Numero_de_parte' => 'required|unique:Material|max:10|min:10|alpha_num',
            'Descripcion' => 'required|unique:Material',
            'ID_Catalogo' => 'required|max:8|min:8|alpha_num',
            'Unidad_de_medida' => 'required|max:3|min:3|alpha',
            'Codigo_sap' => 'required|max:7|min:7|unique:Material|alpha_num',
            'Anaquel' => 'required|digits:2|numeric',
            'Parte_anaquel' => 'required|max:1|min:1',
            'Piso' => 'required|digits:2|numeric',
            'Particion' => 'required|max:1|min:1',
            'Cotizacion' => 'required|numeric|gte:0',

        ]);
        
        DB::select("CALL sp_insert_material ('".$validated['Numero_de_parte']."',
        '".$validated['Descripcion']."',
        '".$validated['ID_Catalogo']."',
        '".$validated['Unidad_de_medida']."',
        '".$validated['Codigo_sap']."',
        '".$validated['Cotizacion']."') ;");
        DB::select("CALL sp_insert_ubicacion (
        '".$validated['Numero_de_parte']."',
        '".$validated['Anaquel']."',
        '".$validated['Parte_anaquel']."',
        '".$validated['Piso']."',
        '".$validated['Particion']."');");
       
    
       
        return redirect('/material');
        
    }
    public function destroy($id)
    {  //return response()->json(["ENVIADOS"=>$id]);
        
        $data = DB::select("call sp_delete_material('".$id."')");

        return redirect('/material');
    }

    public function delete($id, Request $request)
    {  
        try{
            $data = DB::select("call sp_delete_material('$id')");
            return response()->json(['status'=>1,'success'  => $id]);

        }catch(\Exception $e){
            return response()->json(['status'=>0,'error'  => $e]);
        }
    }

    public function show($id)
    {
        $data = DB::select("call sp_listar_catalog_id ('')");
        $material=DB::select("CALL sp_listar_edit_material ('".$id."')");
     
        //return response()->json(["msg"=>$material]);
        return view('material.edit',compact('material','data'));
    }
    public function update(Request $request)
    {
        $Numero_de_parte=$request->Numero_de_parte;
       
    $validated = $request->validate([
        'Descripcion' => 'required',
        'ID_Catalogo' => 'required|max:8|min:8|alpha_num',
        'Unidad_de_medida' => 'required|max:3|min:3|alpha',
        'Anaquel' => 'required|digits:2|numeric',
        'Parte_anaquel' => 'required|max:1|min:1',
        'Piso' => 'required|digits:2|numeric',
        'Particion' => 'required|max:1|min:1',
        'Cotizacion' => 'required|numeric|gte:0',

    ]);
    DB::select("CALL sp_update_material (
        '".$validated['Descripcion']."',
        '".$validated['ID_Catalogo']."',
        '".$validated['Unidad_de_medida']."',
        '".$validated['Cotizacion']."', $Numero_de_parte) ;");

        DB::select("CALL sp_update_ubicacion (
            '".$validated['Anaquel']."',
            '".$validated['Parte_anaquel']."',
            '".$validated['Piso']."',
            '".$validated['Particion']."', 
            '".$Numero_de_parte."');");
    
        return redirect('/material');
       
        //$material->Descripcion=$request->Descripcion
    }

    

    public function showMaterial($code)
    {
        /* Llamado a procedimiento almacenado para mostrar proveedor */
        $data = DB::select("call sp_details_material('".$code."')");

        return response()->json($data);

    }

    public function materialfilter($code)
    {                 
        $datosM=DB::select("CALL sp_listar_materiales_numeroparte ('".$code."')");

        return view('material.index')->with('datosM',$datosM)->with('Title',"Materiales del catalogo ".$code);
       
    }
}



