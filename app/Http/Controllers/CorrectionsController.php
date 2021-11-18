<?php

namespace App\Http\Controllers;

use App\Models\Corrections;
use Illuminate\Http\Request;
use DB;

class CorrectionsController extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {
        $datos = Corrections::orderBy("Codigo_solicitud_correccion","DESC")->paginate();
        return view('Corrections.index',compact('datos'));
    }

    public function storeprocedure($codigo)
    {
        $corrections = DB::select("call sp_buscar_correcciones('.$codigo')");
        return view('Corrections/store')->with('data', $corrections);
    }

    public function create()
    {
        return view('Corrections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Numero_de_parte' => 'required|max:10|min:10|',
            'Diferencia' => 'required',
        ]);
        $data = $request->except("_token");
        Corrections::insert($data);
        return redirect('/Corrections');
    }

    public function show(Corrections $corrections)
    {
        //
    }

    public function edit(Corrections $corrections)
    {
        return view('Corrections.edit',compact('Corrections'));
    }

    public function update(Request $request, Corrections $corrections)
    {
        $request->validate([
            'Codigo_solicitud_correccion' => 'required|max:8|min:8',
            'Numero_de_parte' => 'required|max:10|min:10|',
            'Diferencia' => 'required',
        ]);
        $Corrections->update($request->except("_token"));
        return redirect('/Corrections');
    }

    public function destroy($id)
    {
        Corrections::destroy($id);
        return redirect('/Corrections');
    }
}
