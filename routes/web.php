<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\DevolucionesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaProductoController;
use App\Http\Controllers\SalidaProductoController;
use App\Http\Controllers\RegistrarProductoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('Login.login');
})->name('login');

Route::get('/inicio', function () {
    return view('welcome'); 
})->name('inicio');


Route::get('/inicio-administrador', function () {
    return view('Administrador.inicio-administrador');
})->name('inicio.administrador');


Route::get('/consultar-movimiento', [MovimientosController::class, 'consultarMovimientos'])
    ->name('consultar.movimiento');

Route::get('/modulo-movimiento', function () {
    return view('Modulo-movimientos.modulo-movimiento');
})->name('modulo.movimiento');

Route::post('/movimientos/eliminar', [MovimientosController::class, 'eliminar'])
    ->name('movimientos.eliminar');


Route::get('/registrar-devolucion', function () {
    return view('Modulo-movimientos.registrar-devolucion');
})->name('registrar.devolucion');

Route::get('/devoluciones-index', [DevolucionesController::class, 'index'])
    ->name('devoluciones.index');

Route::post('/devoluciones/crear', [DevolucionesController::class, 'store'])
    ->name('devoluciones.store');

Route::post('/devoluciones/actualizar', [DevolucionesController::class, 'update'])
    ->name('devoluciones.update');

Route::post('/devoluciones/eliminar', [DevolucionesController::class, 'destroy'])
    ->name('devoluciones.destroy');


Route::get('/modulo-usuarios', function () {
    return view('Modulo-usuarios.modulo-usuarios');
})->name('modulo.usuarios');


Route::get('/gestion-usuarios', [UsuariosController::class, 'index'])
    ->name('usuarios.gestion');

Route::post('/usuarios/crear', [UsuariosController::class, 'store'])
    ->name('usuarios.store');

Route::post('/usuarios/actualizar', [UsuariosController::class, 'update'])
    ->name('usuarios.update');

Route::post('/usuarios/eliminar', [UsuariosController::class, 'destroy'])
    ->name('usuarios.destroy');


Route::get('/productos/gestion', function () {
    return view('productos.gestion');
})->name('productos.gestion');

Route::get('/productos/consultar', [ProductoController::class, 'consultar'])
    ->name('productos.consultar');

Route::post('/productos/actualizar', [ProductoController::class, 'actualizar'])
    ->name('productos.actualizar');

Route::post('/productos/desactivar', [ProductoController::class, 'desactivar'])
    ->name('productos.desactivar');


Route::get('/productos/entrada', [EntradaProductoController::class, 'mostrarFormulario'])
    ->name('productos.entrada');

Route::post('/productos/entrada', [EntradaProductoController::class, 'registrarEntrada'])
    ->name('productos.entrada.registrar');


Route::get('/productos/salida', [SalidaProductoController::class, 'mostrarFormulario'])
    ->name('productos.salida');

Route::post('/productos/salida', [SalidaProductoController::class, 'registrarSalida'])
    ->name('productos.salida.registrar');


Route::get('/productos/registrar', [RegistrarProductoController::class, 'mostrarFormulario'])
    ->name('productos.registrar');

Route::post('/productos/registrar', [RegistrarProductoController::class, 'registrarProducto'])
    ->name('productos.registrar.guardar');