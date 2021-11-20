<?php

namespace App\Http\Controllers;

use App\Models\RequestForReinstatement;
use App\Models\Provider;
use App\Http\Livewire\ListRequest;
use Illuminate\Http\Request;
use DB;
use Validator;

class RequestForReinstatementController extends Controller
{
    public function index()
    {
        $datos = DB::select("call mostrar_solicitudes_de_reposicion()");
        return view('RequestForReinstatement.index')->with('datos',$datos);
    }

    public function create()
    {
        $reinstatement = (DB::select("call mostrar_proveedores_por_nombre()"));
        return view('RequestForReinstatement.create',compact('reinstatement'));
    }

    public function store(Request $request)
    {
       
    }
    public function save(Request $request){
        $CodProveedor = $request->Proveedor;
        $FechaRequer = $request->Fecha;
        $error = Validator::make($request->all(),[
            'numParte.*'  => 'required',
            'cant.*'  => 'required|numeric'
        ]);
        if( !($error->passes()) ){
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
            //Nueva Solicitud de Requerimiento
            //DB::select("call sp_nueva_solicitud_reposicion('$CodProveedor','$FechaRequer')");
            //Ingresar Requerimientos (Solicitados)
            foreach ($insert_data as &$valor) {
                //DB::select("call sp_nuevo_solicitado('$valor[numParte]','$valor[cant]','$valor[prior]','$valor[observ]')");
            }
            return response()->json([
            'success'  => 'Data Added successfully.'
            ]);
        }

    }
    public function show($id, Request $request)
    {
        $reinstatement = RequestForReinstatement::find($id);
        $reinstatements0 = (DB::select("call mostrar_solicitados_por_codigo('$id')"));
        //return $reinstatement->provider->Razon_social;
        return view('RequestForReinstatement.show',compact('reinstatement'),compact('reinstatements0'));

        /*$Codprov = auth()->reinstatement('Codigo_proveedor');
        $provid = Provider::find($Codprov);
        */
       // echo "<pre>";
        //print_r($reinstatements0);
    }
    

    public function edit(RequestForReinstatement $requestForReinstatement)
    {
        return view('RequestForReinstatement.edit',compact('requestForReinstatement'));
    }
    public function update(Request $request, RequestForReinstatement $requestForReinstatement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestForReinstatement  $requestForReinstatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestForReinstatement $requestForReinstatement)
    {
        //
    }
}
