<?php

use App\Http\Controllers\Ganancias;
use App\Http\Controllers\Ingresos_egresos;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    
    return view('home.index');
});


Route::group(['prefix'=>'/Ingresos'], function(){
    Route::get('/Nuevo-ingreso',[Ingresos_egresos::class,'Formulario'])->name('Formulario');
    Route::post('/add',[Ingresos_egresos::class,'Add'])->name('Add');
    Route::post('/modificar',[Ingresos_egresos::class,'Modificar'])->name('Modificar');
});


Route::group(['prefix'=>'/Ganancias'], function(){
    Route::get('/',[Ganancias::class,'Ganancias'])->name('Ganancias');
});
