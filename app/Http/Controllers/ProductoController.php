<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class ProductoController extends Controller
{
    private $productoService;

    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

  
    public function consultar()
    {
        $mensaje = "";
        $productos = $this->productoService->obtenerProductos();

        return view('productos.consultar', [
            'productos' => $productos,
            'mensaje' => $mensaje
        ]);
    }

    
    public function consultarEmpleado()
    {
        $mensaje = "";
        $productos = $this->productoService->obtenerProductos();

        return view('Empleado.consultar-productos-empleado', [
            'productos' => $productos,
            'mensaje' => $mensaje
        ]);
    }

   
    public function actualizar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'stockMinimo' => 'required|integer|min:0',
            'stockMaximo' => 'required|integer|min:0',
            'stockActual' => 'required|integer|min:0',
            'idCategoria' => 'required|integer|min:1',
            'idProveedor' => 'required|integer|min:1',
            'estado' => 'required|in:0,1'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.min' => 'El precio debe ser mayor a 0.',
            'stockMinimo.required' => 'El stock mínimo es obligatorio.',
            'stockMaximo.required' => 'El stock máximo es obligatorio.',
            'stockActual.required' => 'El stock actual es obligatorio.',
        ]);

        $id = $request->input('id');
        $mensaje = "";
        $tipo_mensaje = 'error';

        
        if ($request->input('stockMinimo') > $request->input('stockMaximo')) {
            return redirect()->back()->with('error', 'El stock mínimo no puede ser mayor al stock máximo.');
        }

        if ($request->input('stockActual') < $request->input('stockMinimo')) {
            $mensaje = "  ADVERTENCIA: El stock actual está por debajo del mínimo.";
        }

        if ($request->input('stockActual') > $request->input('stockMaximo')) {
            $mensaje = "  ADVERTENCIA: El stock actual excede el máximo permitido.";
        }

        $producto = [
            "nombre" => $request->input('nombre'),
            "precio" => $request->input('precio'),
            "stockMinimo" => $request->input('stockMinimo'),
            "stockMaximo" => $request->input('stockMaximo'),
            "stockActual" => $request->input('stockActual'),
            "idCategoria" => $request->input('idCategoria'),
            "idProveedor" => $request->input('idProveedor'),
            "estado" => $request->input('estado')
        ];

        $resultado = $this->productoService->actualizarProducto($id, $producto);

        if ($resultado["success"]) {
            $tipo_mensaje = 'success';
            $mensaje = "✓ Producto actualizado correctamente." . $mensaje;
        } else {
            $mensaje = "Error: " . ($resultado['error'] ?? 'Desconocido');
        }

        $productos = $this->productoService->obtenerProductos();

        return view('productos.consultar', [
            'productos' => $productos,
            'mensaje' => $mensaje,
            'tipo_mensaje' => $tipo_mensaje
        ]);
    }


    public function desactivar(Request $request)
    {
        $id = intval($request->input('id', 0));
        $mensaje = "";
        $tipo_mensaje = 'error';

        if ($id > 0) {
            $productos = $this->productoService->obtenerProductos();
            $productoActual = null;

            foreach ($productos as $p) {
                if ($p['idProducto'] == $id) {
                    $productoActual = $p;
                    break;
                }
            }

            if ($productoActual) {
                $productoActual['estado'] = '0';
                $resultado = $this->productoService->actualizarProducto($id, $productoActual);

                if ($resultado["success"]) {
                    $mensaje = "✓ Producto desactivado correctamente.";
                    $tipo_mensaje = 'success';
                } else {
                    $mensaje = "Error: " . ($resultado['error'] ?? 'Desconocido');
                }
            } else {
                $mensaje = "Producto no encontrado.";
            }
        } else {
            $mensaje = "ID de producto inválido.";
        }

        $productos = $this->productoService->obtenerProductos();

        return view('productos.consultar', [
            'productos' => $productos,
            'mensaje' => $mensaje,
            'tipo_mensaje' => $tipo_mensaje
        ]);
    }
}