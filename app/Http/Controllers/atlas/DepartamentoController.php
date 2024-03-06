<?php

namespace App\Http\Controllers\atlas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\atlas\Departamento;
use App\Models\atlas\Carrera;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Collection;
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
        $data = json_decode($request->getContent());
        $departamento = new Departamento();
        for ($i=0; $i < count($data->{'carreras'}); $i++) { 
            try {
                $carrera = Carrera::findOrFail($data->{'carreras'}[$i]);
                $departamento->carreras()->associate($carrera);
                $carrera->departamento()->save($departamento);
            } catch (\Throwable $th) {
                throw new HttpException(400, $th);
            }
        }
        $departamento->name = (string) $data->{'name'};
        $departamento->save();
        return response()->json([
            'departamento'=>$departamento
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)//Request $request
    {
        /*$data = json_decode($request->json()->all()[0]);
        $departamento = Departamento::findOrFail($data->{'id'});*/
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
        $data = json_decode($request->getContent());
        /*$carrera = Carrera::findOrFail($data->{'carreras'}[0]);
        $xd = ['_id'=>['$oid' => $data->{'carreras'}[0]],'name'=>$carrera->name];
        var_dump($xd);
        throw new HttpException(400,$xd);*/
        //OBETENEMOS LA COLECCION DE CARREAS EN EL DEPARTAMENTO EXISTENTE
        if(count($data->{'carreras'})>0){
            $carrerasDepto = $departamento->carreras();
        }
        if(isset($data->{'detach'}) && $data->{'detach'} == True){
            for ($i=0; $i < count($data->{'carreras'}); $i++) { 
                try {
                    $carrera = Carrera::findOrFail($data->{'carreras'}[$i]);
                    if(!$carrerasDepto->contains($carrera)){
                        //$departamento->carreras()->detach($data->{'carreras'}[$i]);
                        $departamento->removerCarrera();
                        $carrera->departamento()->dissociate();
                        $departamento->save();
                    }
                } catch (\Throwable $th) {
                    throw new HttpException(400, $th);
                }
            }
        }else{
            for ($i=0; $i < count($data->{'carreras'}); $i++) { 
                try {
                    $carrera = Carrera::findOrFail($data->{'carreras'}[$i]);
                    if($carrerasDepto->contains($carrera)){
                        $departamento->carreras()->associate($carrera);
                        $carrera->departamento()->save($departamento);
                    }
                } catch (\Throwable $th) {
                    throw new HttpException(400, $th);
                }
            }
            if(isset($data->{'name'}) && $data->{'name'} != ''){
                $departamento->name = $data->{'name'};
            }
            $departamento->save();
        }
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
            'message'=>'Borrado!'
        ]);
    }
}
