<?php

namespace App\Http\Controllers;

use App\Models\CorrectionRequest;
use Illuminate\Http\Request;

class CorrectionRequestController extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {
        $datos = CorrectionRequest::orderBy("Codigo_solicitud_correccion","DESC")->paginate();
        return view('CorrectionRequest.index',compact('datos'));
    
    }

    public function create()
    {
        return view('CorrectionRequest.create')->with("Next",$this->calculateCodigo());
    }

    public function store(Request $request)
    {
        $request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Codigo_reposicion' => 'required|max:6|min:6|',
            'Codigo_guia_remision' => 'required|max:14|min:14|',
            'Motivo' => 'required|max:100|min:6|',
            'Fecha' => 'required',
        ]);
        $data = $request->except("_token");
        CorrectionRequest::insert($data);
        return redirect('/CorrectionRequest');
    }

    private function calculateCodigo(){
        $last = CorrectionRequest::select('Codigo_solicitud_correccion')->orderBy("Codigo_solicitud_correccion","DESC")->get()->first();
        $id = (empty($last)) ? "SC000000" : $last["Codigo_solicitud_correccion"];
        $next = strval(intval(substr($id,1,strlen($id))) + 1);
        return "C".str_repeat("0",7-strlen($next)).$next;
    }

    public function show(CorrectionRequest $CorrectionRequest)
    {
        //
    }

    public function edit(CorrectionRequest $CorrectionRequest)
    {
        return view('CorrectionRequest.edit',compact('CorrectionRequest'));
    }


    public function update(Request $request, CorrectionRequest $CorrectionRequest)
    {
        $request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Codigo_reposicion' => 'required|max:6|min:6|',
            'Codigo_guia_remision' => 'required|max:14|min:14|',
            'Motivo' => 'required|max:100|min:6|',
            'Fecha' => 'required',
        ]);
        $CorrectionRequest->update($request->except("_token"));
        return redirect('/CorrectionRequest');
    }

    
    public function destroy(CorrectionRequest $CorrectionRequest)
    {
        //
    }
}
