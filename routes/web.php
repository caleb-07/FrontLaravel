<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;

Route::get('/', function () {
    return view('welcome');
});
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

Route::post('/movimientos/eliminar', [MovimientoController::class, 'eliminar'])
     ->name('movimientos.eliminar');
