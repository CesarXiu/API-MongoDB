<?php

namespace App\Http\Controllers\atlas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\atlas\Carrera;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarreraController extends Controller
{
    //
    public function index(Request $request)
    {
        //$carreras = DB::collection('Carreras')->get();
        $carreras = Carrera::all();
        return response()->json([
            'carreras'=>$carreras,
            //'request' => $request
        ]); 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //$data = $request->all();
        $carrera = new Carrera();
        $data = json_decode($request->getContent());
        $carrera->name = (string) $data->{'name'};
        //$carrera->fill($data);
        $carrera->save();

        return response()->json([
            'carrera'=>$carrera
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrera $carrera)
    {
        //
        return response()->json([
            'carrera'=>$carrera
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrera $carrera)
    {
        //$jsonString = json_decode($request->getContent(),true);
        $data = request()->json();
        $carrera->name = $data->get("name");
        $carrera->save();
        return response()->json([
            'carrera'=>$carrera
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera)
    {
        //
        $carrera->delete();
        return response()->json([
            'message'=>'Borrado!'
        ]);
    }
}
