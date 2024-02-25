<?php

namespace App\Http\Controllers\API;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Alancting\Microsoft\JWT\AzureAd\AzureAdConfiguration;
use Alancting\Microsoft\JWT\AzureAd\AzureAdAccessTokenJWT;
use Alancting\Microsoft\JWT\AzureAd\AzureAdIdTokenJWT;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //private $string_microsoftPublicKeyURL = 'https://login.microsoftonline.com/9af622ec-f1a5-4422-bdc9-8c20039ed9eb/discovery/v2.0/keys';
    //9af622ec-f1a5-4422-bdc9-8c20039ed9eb
    private $config_options = [
        'tenant' => '9af622ec-f1a5-4422-bdc9-8c20039ed9eb',
        'tenant_id' => '9af622ec-f1a5-4422-bdc9-8c20039ed9eb',
        'client_id' => 'ab3eaf82-413c-4808-b011-0086680b9795'
    ];
    private $audience = "87ce3de8-5800-4291-98bc-628c7d525bf7";
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
