<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
//use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class RequestForReinstatementController extends Controller
{

    public function index()
    {
        $datos = DB::select("call sp_mostrar_solicitudes_de_reposicion()");
        $datos = $this->paginateCollection($datos, 5);
        $datos->setpath('RequestForReinstatement');

        return view('RequestForReinstatement.index',compact('datos'));
    }
    public function search(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $datos = DB::select("call sp_buscar_solicitudReposicion_entre_fechas('$fromDate','$toDate')");
        $datos = $this->paginateCollection($datos,5);
        $datos->setpath($request->path());
        return view('RequestForReinstatement.index',compact('datos'));
    }
    public function searchdisabled(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $datos = DB::select("call sp_buscar_solicitudReposicion_desabilitados_entre_fechas('$fromDate','$toDate')");
        $datos = $this->paginateCollection($datos,5);
        $datos->setpath('disabled');
        return view('RequestForReinstatement.disabled',compact('datos'));
    }
    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function create()
    {
        $materials = DB::select("call sp_nroDeParte_UnindadMedida()");
        $reinstatement = (DB::select("call sp_mostrar_proveedores_por_nombre()"));
        $nuevoCodigo = DB::select("call sp_generar_codigo_para_solicitud_de_reposicion()");
        return view('RequestForReinstatement.create',compact('reinstatement', 'materials', 'nuevoCodigo'));
    }
    public function save(Request $request)
    {
        $CodReposicion = $request->Codigo_reposicion;
        $CodProveedor = $request->Proveedor;
        $FechaRequer = $request->Fecha;
        $error = Validator::make($request->all(),[
            'numParte.*'  => 'required',
            'cant.*'  => 'required|numeric',
            'Fecha' => 'required',
            'Proveedor' => 'required'
        ]);
        $unique = array_unique($request->numParte);
        $duplicates = array_diff_assoc($request->numParte, $unique);

        if( (!($error->passes())) || (count($duplicates) != 0) ){
            return response()->json(['status'=>0,'error' => $error->errors()->toArray()]);
        }
        else
        {
            $numParte = $request->numParte;
            $cant = $request->cant;
            $array = $request->prior;
            $long = count($request->prior);
            for($i = 0; $i < $long; $i++){
                if($array[$i] != "1"){
                    $array[$i] = '0';
                }
                else{
                    unset($array[$i-1]);
                }
            }
            $prior = array_values($array);
            $observ = $request->observ;
            for($count = 0; $count < count($numParte); $count++)
            {
                $data = array(
                    'numParte' => $numParte[$count],
                    'cant'  => $cant[$count],
                    'prior' => $prior[$count],
                    'observ' => $observ[$count]
                );
                $insert_data[] = $data;
            }
            //Nueva Solicitud de Requerimiento o Actualizacion de la misma
            DB::select("call sp_agregar_o_actualizar_solicitud_reposicion('$CodReposicion','$CodProveedor','$FechaRequer')");
            //Ingresar Requerimientos (Solicitados)
            DB::select("call sp_softdelete_para_solicitados('$CodReposicion')");
            foreach ($insert_data as &$valor) {
                DB::select("call sp_agregar_o_actualizar_solicitado('$valor[numParte]','$CodReposicion','$valor[cant]','$valor[prior]','$valor[observ]')");
            }
            return response()->json(['status'=>2, 'success'  => 'Data Added successfully.']);
        }

    }
    public function showRequirement($id, Request $request)
    {
        $reinstatement = DB::select("call sp_detalle_de_SolicitudReposicion('$id')");
        $reinstatements0 = (DB::select("call sp_mostrar_solicitados_por_codigo('$id')"));
        return view('RequestForReinstatement.show',compact('reinstatement'),compact('reinstatements0'));
    }
    public function edit($requestForReinstatement)
    {
        $materials = DB::select("call sp_nroDeParte_UnindadMedida()");
        $proveedores = (DB::select("call sp_mostrar_proveedores_por_nombre()"));
        $actuales = DB::select("call sp_detalle_de_SolicitudReposicion('$requestForReinstatement')");
        $reinstatements0 = (DB::select("call sp_mostrar_solicitados_por_codigo('$requestForReinstatement')"));
        for($x = 0; $x<count($proveedores); $x++){
            if($proveedores[$x]->Codigo_proveedor == $actuales[0]->Codigo_proveedor){
                unset($proveedores[$x]);
            }
        }
        return view('RequestForReinstatement.edit',compact('actuales', 'proveedores', 'materials','reinstatements0'));
    }
    public function delete($id)
    {
        DB::select("call sp_softdelete_para_solicitud_de_reposicion('$id')");
        return response()->json(['status'=>1,'success'  => 'Data deleted successfully.']);
    }
    public function enable($id)
    {
        DB::select("call sp_habilitar_para_solicitud_de_reposicion('$id')");
        return response()->json(['status'=>1,'success'  => 'Data deleted successfully.']);
    }
    public function disabled(){
        $datos = DB::select("call sp_mostrar_solicitudes_de_reposicion_desabilitadas()");
        $datos = $this->paginateCollection($datos, 5);
        $datos->setpath('disabled');
        return view('RequestForReinstatement.disabled',compact('datos'));    
    }
    public function showRequirementDisabled($id, Request $request)
    {
        $reinstatement = DB::select("call sp_detalle_de_SolicitudReposicion('$id')");
        $reinstatements0 = (DB::select("call sp_mostrar_solicitados_por_codigo_desabilitados('$id')"));
        return view('RequestForReinstatement.show',compact('reinstatement'),compact('reinstatements0'));
    }
    public function export($id)
    {
        $cab = DB::select("call sp_detalle_de_SolicitudReposicion('$id')");
        $data = (DB::select("call sp_export_invidivual_solicitud_de_reposicion('$id')"));
        $proveed = DB::select("call sp_detalle_de_SolicitudReposicion_pdf('$id')");
        $datos = compact('cab','data','proveed');
        $pdf = PDF::loadView('RequestForReinstatement.export',$datos)->setPaper('a4', 'landscape');;
        return $pdf->stream("Solicitud de Reposicion ".$id.".pdf");
    }
}