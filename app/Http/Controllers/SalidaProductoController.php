<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class SalidaProductoController extends Controller
{
    private $productoService;

    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

    public function mostrarFormulario()
    {
        $todosProductos = $this->productoService->obtenerProductos();
        
        // Filtrar solo productos activos
        $productosActivos = array_filter($todosProductos, function($p) {
            return $p['estado'] == '1';
        });

        return view('productos.salida-producto', [
            'productos' => $productosActivos
        ]);
    }

    public function registrarSalida(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|integer|min:1',
            'cantidadRetirar' => 'required|integer|min:1'
        ], [
            'idProducto.required' => 'Debe seleccionar un producto.',
            'cantidadRetirar.required' => 'Debe ingresar una cantidad.',
            'cantidadRetirar.min' => 'La cantidad debe ser al menos 1.'
        ]);

        $idProducto = $request->input('idProducto');
        $cantidadRetirar = $request->input('cantidadRetirar');

        $productos = $this->productoService->obtenerProductos();
        $productoActual = null;

        foreach ($productos as $p) {
            if ($p['idProducto'] == $idProducto) {
                $productoActual = $p;
                break;
            }
        }

        if (!$productoActual) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Validar stock suficiente
        if ($productoActual['stockActual'] < $cantidadRetirar) {
            return redirect()->back()
                ->withInput()
                ->with('error', "❌ Stock insuficiente. Disponible: {$productoActual['stockActual']}, Solicitado: {$cantidadRetirar}");
        }

        // Solo actualizar stockActual (eliminamos la línea de stock)
        $nuevoStockActual = $productoActual['stockActual'] - $cantidadRetirar;

        // Verificar si queda por debajo del mínimo
        $advertencia = "";
        if ($nuevoStockActual < $productoActual['stockMinimo']) {
            $advertencia = " ⚠️ ADVERTENCIA: El stock está por debajo del mínimo requerido ({$productoActual['stockMinimo']}).";
        }

        $productoActual['stockActual'] = $nuevoStockActual;

        $resultado = $this->productoService->actualizarProducto($idProducto, $productoActual);

        if ($resultado["success"]) {
            return redirect()->back()->with('success', "✓ Salida registrada correctamente. Nuevo stock: {$nuevoStockActual}{$advertencia}");
        } else {
            return redirect()->back()->with('error', "Error: {$resultado['error']}");
        }
    }
}