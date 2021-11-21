<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $datos = Supplier::orderBy("Codigo_proveedor","DESC")->paginate(5);
        return view('supplier.index',compact('datos'));
    }

    public function create()
    {
        return view('supplier.create')->with("Next",$this->calculateID());
    }

    public function store(Request $request)
    {
        $request->validate([
            'Codigo_Proveedor' => 'required|max:10|min:10',
            'Razon_social' =>  'required|max:50|min:5',
            'RUC' => 'required|max:11|min:11'
        ]);
        $data = $request->except("_token");
        Supplier::insert($data);
        return redirect('/supplier');
    }

    /*Convertir a procedimiento almacenado*/
    private function calculateID(){
        $last = Supplier::select('Codigo_proveedor') ->orderBy("Codigo_proveedor","DESC")-> get()->first();
      }

    public function show($id)
    {
        
        $supplier = Supplier::findOrFail($id);
        $phone = DB::select("call obtener_telefono('".$id."')");
        $address = DB::select("call obtener_direccion('".$id."')");
        $email = DB::select("call obtener_correo('".$id."')");
        return view('supplier.show')
            ->with(compact('supplier'))
            ->with(compact('phone'))
            ->with(compact('address'))
            ->with(compact('email'));
    }
    
    public function edit(Supplier $supplier)
    {
        //
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        /*$request->validate([
            'Codigo_Proveedor' => 'required|max:10|min:10',
            'Razon_social' =>  'required|max:50|min:5',
            'RUC' => 'required|max:11|min:11'
        ]);
        $data = $request->except("_token");
        return redirect('/supplier');*/
    }

    public function destroy($Id)
    {
        try{
            $supplier = DB::select("call Eliminar_proveedor('".$Id."')");
            return redirect()->route('supplier.index')->with('Eliminar','Ok');
        }catch(\Exception $e){
            return redirect()->route('supplier.index')->with('Eliminar','Bad');
        }
    }
    
   
    public function searchEmail($code){
        
        $data = DB::table('correos')
                ->select('correos.Id_correo',
                    'correos.Correo')
                ->join('proveedor','proveedor.Codigo_proveedor','=','correos.Codigo_proveedor')

                ->where('correos.Id_correo','=',$code)
                ->get();
        return response()->json($data);

    }
    public function searchAddress($code){
        
        $data = DB::table('direcciones')
                ->select('direcciones.Id_direccion',
                    'direcciones.Direccion')
                ->join('proveedor','proveedor.Codigo_proveedor','=','direcciones.Codigo_proveedor')

                ->where('direcciones.Id_direccion','=',$code)
                ->get();
        return response()->json($data);

    }
    public function searchPhone($code){
        
        $data = DB::table('telefono')
                ->select('telefono.Id_telefono',
                    'telefono.Telefono')
                ->join('proveedor','proveedor.Codigo_proveedor','=','telefono.Codigo_proveedor')

                ->where('telefono.Id_telefono','=',$code)
                ->get();
        return response()->json($data);

    }
}
