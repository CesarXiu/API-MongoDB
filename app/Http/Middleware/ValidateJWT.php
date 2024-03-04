<?php

namespace App\Http\Middleware;

use Alancting\Microsoft\JWT\AzureAd\AzureAdConfiguration;
use Alancting\Microsoft\JWT\AzureAd\AzureAdAccessTokenJWT;
use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class ValidateJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private $config_options;
    private $audience;
    public function __construct(){
        $dotenv = \Dotenv\Dotenv::createImmutable(base_path());
        $dotenv->load(); //CARGAMOS LOS VALORES DE ENV

        $this->config_options = [
            'tenant' => env('AZURE_TENANT'),
            'tenant_id' => env('AZURE_TENANT'),
            'client_id' => env('AZURE_CLIENT_ID'),
        ];
        $this->audience = env('AZURE_AUDIENCE');
    }

    public function handle(Request $request, Closure $next): Response
    {
        if($request->hasHeader('Authorization')){
            $authorization = explode(' ', $request->header("Authorization"))[1];
            $config = new AzureAdConfiguration($this->config_options);
            $access_token_jwt = new AzureAdAccessTokenJWT($config, $authorization, $this->audience);
            //$decoded = "XD";//($access_token_jwt == null);
            if(!$access_token_jwt->isExpired()){
                $request->additional_info = $access_token_jwt->getPayload();
                return $next($request);
            }else{
                throw new HttpException(400, 'Your token has expired');
            }
        }else{
            throw new HttpException(400, 'Header "Authorization" expected but not founded in request');
        }
    }
}
