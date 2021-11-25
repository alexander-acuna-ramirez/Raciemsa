<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $datos = Catalog::orderBy("ID_Catalogo","DESC")->paginate(5);
        return view('catalog.index',compact('datos'));
    }

    public function create()
    {
        return view('catalog.create')->with("Next",$this->calculateID());
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Catalogo' => 'required|max:8|min:8',
            'Ubicacion' => 'required|max:4|min:4|alpha_num',
        ]);
        $data = $request->except("_token");
        Catalog::insert($data);
        //return response()->json(["ENVIADOS"=>$request->except("_token")]);
        return redirect('/catalog');
    }

    /* CONVERTIR A PROCEDIMIENTO ALMACENADO */
    private function calculateID(){
        $last = Catalog::select('ID_Catalogo')->orderBy("ID_Catalogo","DESC")->get()->first();
        $id = (empty($last)) ? "C000000" : $last["ID_Catalogo"];
        $next = strval(intval(substr($id,1,strlen($id))) + 1);
        return "C".str_repeat("0",7-strlen($next)).$next;
    }

    public function show(Catalog $catalog)
    {
        //
    }

    public function edit(Catalog $catalog)
    {
        //
    }   


    public function update(Request $request, Catalog $catalog)
    {
        $request->validate([
            'ID_Catalogo' => 'required|max:8|min:8',
            'Ubicacion' => 'required|max:4|min:4|alpha_num',
        ]);
        $catalog->update($request->except("_token"));
        return redirect('/catalog');
        //return response()->json(["msg"=>"Something new"]);
    }

    public function destroy($id)
    {
        Catalog::destroy($id);
        return redirect('/catalog');
    }
}
