<?php

namespace App\Http\Controllers\API;

use App\Models\Movie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $string_microsoftPublicKeyURL = 'https://login.microsoftonline.com/9af622ec-f1a5-4422-bdc9-8c20039ed9eb/discovery/v2.0/keys';
    public function getPublicKeyFromX5C($string_certText) {
        $object_cert = openssl_x509_read($string_certText);
        $object_pubkey = openssl_pkey_get_public($object_cert);
        $array_publicKey = openssl_pkey_get_details($object_pubkey);
        return $array_publicKey['key'];
    }
    public function loadKeysFromAzure($string_microsoftPublicKeyURL) {
        $array_keys = array();

        $jsonString_microsoftPublicKeys = file_get_contents($string_microsoftPublicKeyURL);
        $array_microsoftPublicKeys = json_decode($jsonString_microsoftPublicKeys, true);

        foreach($array_microsoftPublicKeys['keys'] as $array_publicKey) {
            $string_certText = "-----BEGIN CERTIFICATE-----\r\n".chunk_split($array_publicKey['x5c'][0],64)."-----END CERTIFICATE-----\r\n";
            $array_keys[$array_publicKey['kid']] = $this->getPublicKeyFromX5C($string_certText);
        }

        return $array_keys;
    }
    public function index(Request $request)
    {
        //$headers = $request->headers->all();
        if($request->hasHeader('Authorization')){
            $authorization = $request->header("Authorization");
            $array_publicKeysWithKIDasArrayKey = $this->loadKeysFromAzure($this->string_microsoftPublicKeyURL);
            //---
            $jwt = str_replace('Bearer ', '', $authorization);
            // Verifica el token JWT
            // Suponiendo que $array_publicKeysWithKIDasArrayKey es tu arreglo de claves públicas
            $KidFinal = "";
            $dec = "";
            foreach ($array_publicKeysWithKIDasArrayKey as $kid => $publicKey) {
                try {
                    $KidFinal = "";
                    $dec = "";
                    // Decodificar el token JWT con la clave pública actual
                    $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));
                    // Si la decodificación es exitosa, significa que esta clave se utilizó para firmar el token
                    $KidFinal = $kid;
                    $dec = $decoded;
                    break; // Salir del bucle ya que hemos encontrado la clave correcta
                } catch (\Exception $e) {
                    // Si ocurre una excepción, continuar con la siguiente clave
                    continue;
                }
            }
            //---
            $movies = Movie::all();
            return response()->json([
                'movies'=>$movies,
                'token'=>$authorization,
                'kid' => $KidFinal,
                "decoded" => $dec,
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
