<?php

namespace App\Http\Controllers\atlas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\atlas\Departamento;
class DepartamentoController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$departamentos = DB::collection('Departamentos')->get();
        $departamentos = Departamento::all();
        return response()->json([
            'departamentos'=>$departamentos,
            //'request' => $request
        ]); 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $departamento = new Departamento();
        $departamento->fill($data);
        $departamento->save();
        return response()->json([
            'departamento'=>$departamento
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        //
        return response()->json([
            'departamento'=>$departamento
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        //
        //dd($movie);
        $departamento->fill($request->all())->save();
        return response()->json([
            'departamento'=>$departamento
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        //
        $departamento->delete();
        return response()->json([
            'message'=>'Borrado con exitacion!'
        ]);
    }
}
