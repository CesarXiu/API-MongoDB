<?php

namespace App\Http\Controllers\API;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Alancting\Microsoft\JWT\AzureAd\AzureAdConfiguration;
use Alancting\Microsoft\JWT\AzureAd\AzureAdAccessTokenJWT;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $config_options;
    private $audience;
    public function __construct(){
        $this->config_options = [
            'tenant' => $this->getTenant(),
            'tenant_id' => $this->getTenant(),
            'client_id' => $this->getClient()
        ];
        $this->audience = $this->getAudience();
    }
    public function getTenant(){
        return env('AZURE_TENANT');
    }
    public function getClient(){
        return env('AZURE_CLIENT_ID');
    }
    public function getAudience(){
        return env('AZURE_AUDIENCE');
    }
    public function index(Request $request)
    {
        //$headers = $request->headers->all();
        if($request->hasHeader('Authorization')){
            $authorization = explode(' ', $request->header("Authorization"))[1];
            //---
            $config = new AzureAdConfiguration($this->config_options);
            $access_token_jwt = new AzureAdAccessTokenJWT($config, $authorization, $this->audience);
            //---
            $movies = Movie::all();
            return response()->json([
                'movies'=>$movies,
                'token'=>$authorization,
                'payload'=> $access_token_jwt->getPayload()
            ]);
        }else{
            return response()->json([
                'error'=>'NOT A VALID REQUEST, AUTHORIZATION REQUIRED',
            ]);
        }
    }
    public function validateJwt(){

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->fill($data);
        $movie->save();
        return response()->json([
            'movie'=>$movie
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
        return response()->json([
            'movie'=>$movie
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
        //dd($movie);
        $movie->fill($request->all())->save();
        return response()->json([
            'movie'=>$movie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
        $movie->delete();
        return response()->json([
            'message'=>'Borrado con exitacion!'
        ]);
    }

}
