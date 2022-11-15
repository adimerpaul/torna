<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
//Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
    Route::post('/me', [App\Http\Controllers\UserController::class, 'me']);
    Route::apiResource('transporte', App\Http\Controllers\TransporteController::class);
    Route::apiResource('contratista', App\Http\Controllers\ContratistaController::class);
    Route::apiResource('empresa', App\Http\Controllers\EmpresaController::class);
    Route::apiResource('tornaguia', App\Http\Controllers\TornaguiaController::class);
});
