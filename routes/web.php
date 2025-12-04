<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\DevolucionesController;


Route::get('/', function () {
    return view('welcome');
});

    //Login Routes
 Route::get('/login', function () {
    return view('Login.login');
})->name('login');

    //Administrador Routes

Route::get('inicio-administrador', function () {
    return view('Administrador.inicio-administrador');
})->name('inicio.administrador');

    //Movimientos Routes

Route::get('/consultar-movimiento', [MovimientosController::class, 'consultarMovimientos'])
    ->name('consultar.movimiento');

Route::get('/modulo-movimiento', function () {
    return view('Modulo-movimientos.modulo-movimiento');
})->name('modulo.movimiento');

Route::post('/movimientos/eliminar', [MovimientosController::class, 'eliminar'])
     ->name('movimientos.eliminar');

     //Devoluciones Routes

Route::get('/registrar-devolucion', function () {
    return view('Modulo-movimientos.registrar-devolucion');
})->name('registrar.devolucion');     

Route::get('/registrar-devolucion', [DevolucionesController::class, 'index'])
    ->name('devoluciones.index');

Route::post('/devoluciones/crear', [DevolucionesController::class, 'store'])
    ->name('devoluciones.store');

Route::post('/devoluciones/actualizar', [DevolucionesController::class, 'update'])
    ->name('devoluciones.update');

Route::post('/devoluciones/eliminar', [DevolucionesController::class, 'destroy'])
    ->name('devoluciones.destroy');