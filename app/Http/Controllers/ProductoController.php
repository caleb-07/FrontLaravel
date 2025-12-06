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

    // Actualizar producto
    public function actualizar(Request $request)
    {
        $mensaje = "";
        $tipo_mensaje = 'error';

        $id = intval($request->input('id', 0));
        $nombre = trim($request->input('nombre', ''));
        $precio = floatval($request->input('precio', 0));

        if ($id > 0 && !empty($nombre)) {
            $producto = [
                "nombre" => $nombre,
                "precio" => $precio,
                "stock" => intval($request->input('stock', 0)),
                "stockMinimo" => intval($request->input('stockMinimo', 0)),
                "stockMaximo" => intval($request->input('stockMaximo', 0)),
                "stockActual" => intval($request->input('stockActual', 0)),
                "idCategoria" => intval($request->input('idCategoria', 0)),
                "idProveedor" => intval($request->input('idProveedor', 0)),
                "estado" => $request->input('estado', '1')
            ];

            $resultado = $this->productoService->actualizarProducto($id, $producto);

            $mensaje = $resultado["success"]
                ? "Producto actualizado correctamente."
                : "Error: " . ($resultado['error'] ?? 'Desconocido');

            $tipo_mensaje = $resultado["success"] ? 'success' : 'error';
        } else {
            $mensaje = "Datos inválidos.";
        }

        $productos = $this->productoService->obtenerProductos();

        return view('productos.consultar', [
            'productos' => $productos,
            'mensaje' => $mensaje,
            'tipo_mensaje' => $tipo_mensaje
        ]);
    }

    // Desactivar producto
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

                $mensaje = $resultado["success"]
                    ? "Producto desactivado correctamente."
                    : "Error: " . ($resultado['error'] ?? 'Desconocido');

                $tipo_mensaje = $resultado["success"] ? 'success' : 'error';
            } else {
                $mensaje = "Producto no encontrado.";
            }
        }

        $productos = $this->productoService->obtenerProductos();

        return view('productos.consultar', [
            'productos' => $productos,
            'mensaje' => $mensaje,
            'tipo_mensaje' => $tipo_mensaje
        ]);
    }
}