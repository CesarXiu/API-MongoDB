<?php

namespace App\Http\Controllers\atlas;

use App\Http\Controllers\Controller;
use App\Models\atlas\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AlumnoController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        //$alumnos = DB::collection('Alumnos')->get();
        $alumnos = Alumno::all();
        return response()->json([
            'alumnos'=>$alumnos,
            //'request' => $request
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $alumno = new Alumno();
        $alumno->fill($data);
        $alumno->save();
        return response()->json([
            'alumno'=>$alumno
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        //
        return response()->json([
            'alumno'=>$alumno
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        //
        //dd($movie);
        $alumno->fill($request->all())->save();
        return response()->json([
            'alumno'=>$alumno
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        //
        $alumno->delete();
        return response()->json([
            'message'=>'Borrado con exitacion!'
        ]);
    }

}
