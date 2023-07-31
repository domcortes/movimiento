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
    Route::post('crear', [\App\Http\Controllers\UsuariosController::class,'createUser'])->name('usuario.crearUsuario');
   Route::post('revisar', [\App\Http\Controllers\UsuariosController::class, 'checkRut'])->name('usuario.checkRut');
   Route::post('marcar-asistencia', [\App\Http\Controllers\UsuariosController::class, 'crearAsistencia'])->name('usuario.marcarAsistencia');
   Route::post('check-deportes', [\App\Http\Controllers\UsuariosController::class, 'revisarDeportes'])->name('usuario.checkMensualidad');
});

Route::group(['prefix' => 'informaciones'], function(){
    Route::get('privacidad',[\App\Http\Controllers\SystemController::class, 'privacidad'])->name('informaciones.privacidad');
});
