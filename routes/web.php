<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('usuarios', \App\Http\Controllers\UsuariosController::class);
Route::resource('pagos', \App\Http\Controllers\PagosController::class);
Route::resource('asistencias', \App\Http\Controllers\AsistenciasController::class);

Route::group(['prefix' => 'usuario'], function(){
   Route::post('revisar', [\App\Http\Controllers\UsuariosController::class, 'checkRut'])->name('usuario.checkRut');
});
