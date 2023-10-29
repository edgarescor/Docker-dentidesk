<?php

use App\Http\Controllers\Ganancias;
use App\Http\Controllers\Ingresos_egresos;
use App\Http\Controllers\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'/Funciones'], function(){
    Route::post('/Eliminar-ingreso',[Ingresos_egresos::class,'Eliminar'])->name('Eliminar');
});

Route::group(['prefix'=>'/Transacciones'], function(){
    Route::post('/mes',[Rest::class,'BuscarTransacciones'])->name('BuscarTransacciones');
    Route::get('/',[Rest::class,'TodasTransacciones'])->name('TodasTransacciones');
    Route::post('/',[Rest::class,'IngresoTransaccion'])->name('IngresoRest');
    Route::put('/',[Rest::class,'ActualizacionTransaccion'])->name('ActualizacionRest');
    Route::delete('/',[Rest::class,'EliminacionTransaccion'])->name('EliminacionRest');
});
