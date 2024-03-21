<?php

use App\Http\Controllers\PlanesController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\SystemController;
use App\Models\Planes;
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
    $logos = [
        'vendor/adminlte/dist/img/logo1.png',
        'vendor/adminlte/dist/img/logo2.png',
        'vendor/adminlte/dist/img/logo3.png',
        'vendor/adminlte/dist/img/logo4.png',
        'vendor/adminlte/dist/img/logo5.png',
        'vendor/adminlte/dist/img/logo6.png',
        'vendor/adminlte/dist/img/logo7.png',
        'vendor/adminlte/dist/img/logo8.png',
        'vendor/adminlte/dist/img/logo9.png'
    ];

    $indiceAzar = array_rand($logos);
    $logoSeleccionado = $logos[$indiceAzar];

    $planes = Planes::all();

    return view('welcome', compact('logoSeleccionado', 'planes'));
})->name('welcome');


Route::group(['prefix' => 'asistencia'], function () {
    Route::get('/', function () {
        $logos = [
            'vendor/adminlte/dist/img/logo1.png',
            'vendor/adminlte/dist/img/logo2.png',
            'vendor/adminlte/dist/img/logo3.png',
            'vendor/adminlte/dist/img/logo4.png',
            'vendor/adminlte/dist/img/logo5.png',
            'vendor/adminlte/dist/img/logo6.png',
            'vendor/adminlte/dist/img/logo7.png',
            'vendor/adminlte/dist/img/logo8.png',
            'vendor/adminlte/dist/img/logo9.png'
        ];

        $indiceAzar = array_rand($logos);
        $logoSeleccionado = $logos[$indiceAzar];

        $planes = Planes::all();

        return view('asistencia', compact('logoSeleccionado', 'planes'));
    })->name('asistencia');

    Route::post('buscar-clases', [AsistenciasController::class, 'buscarClases'])->name('asistencia.buscarClases');
    Route::post('marcar-asistencia', [AsistenciasController::class, 'marcarAsistencia'])->name('asistencia.marcar');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('usuarios', \App\Http\Controllers\UsuariosController::class);
Route::resource('pagos', \App\Http\Controllers\PagosController::class);
Route::post('actualizar-pago', [\App\Http\Controllers\PagosController::class, 'updatePayment'])->name('pago.actualizarPago');

Route::resource('asistencias', \App\Http\Controllers\AsistenciasController::class);
Route::get('asistencias-sin-pago', [\App\Http\Controllers\AsistenciasController::class, 'indexPendientes'])->name('asistencias.pendientes');

Route::group(['prefix' => 'usuario'], function () {
    Route::post('crear', [\App\Http\Controllers\UsuariosController::class, 'createUser'])->name('usuario.crearUsuario');
    Route::post('revisar', [\App\Http\Controllers\UsuariosController::class, 'checkRut'])->name('usuario.checkRut');
    Route::post('marcar-asistencia', [\App\Http\Controllers\UsuariosController::class, 'crearAsistencia'])->name('usuario.marcarAsistencia');
    Route::post('check-deportes', [\App\Http\Controllers\UsuariosController::class, 'revisarDeportes'])->name('usuario.checkMensualidad');
});

Route::group(['prefix' => 'informaciones'], function () {
    Route::get('privacidad', [\App\Http\Controllers\SystemController::class, 'privacidad'])->name('informaciones.privacidad');
    Route::get('reglamento', [\App\Http\Controllers\SystemController::class, 'reglamento'])->name('informaciones.reglamento');
    Route::get('whatsapp', [\App\Http\Controllers\SystemController::class, 'whatsappNotification'])->name('informaciones.whatsapp');
});

Route::resource('profesores', ProfesoresController::class);
Route::resource('alumnos', AlumnosController::class);
Route::resource('planes', PlanesController::class);
Route::resource('clases', ClasesController::class);

Route::get('planes/get-plan/{id}', [PlanesController::class, 'getPlanFromId']);

Route::group(['prefix' => 'payments'], function () {
    Route::post('crear-pago-tbk', [SystemController::class, 'crearPago'])->name('payments.crearPago');
    Route::get('respuesta-tbk/{hash}', [SystemController::class, 'respuestaTbk'])->name('payments.respuestaTbk');
    Route::get('transbank/{hash}/{pago}', [SystemController::class, 'redireccionTbk'])->name('payments.redireccionTbk');
    Route::get('transbank/fallo', [SystemController::class, 'redireccionTbkFallo'])->name('payments.redireccionTbkFallo');
});
