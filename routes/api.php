<?php

use App\Http\Controllers\API\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\atlas\AlumnoController;
use App\Http\Controllers\atlas\CarreraController;
use App\Http\Controllers\atlas\DepartamentoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*
Route::resource('movies',MovieController::class)->only('index','store','destroy','show','update');
Route::resource('authors',AuthorController::class)->only('index','store','destroy','show','update');
*/
Route::resource('carreras',CarreraController::class)->only('index','store','destroy','show','update');
Route::resource('departamentos',DepartamentoController::class)->only('index','store','destroy','show','update');

//Route::resource('alumnos',AlumnoController::class)->only('index','store','destroy','show','update');