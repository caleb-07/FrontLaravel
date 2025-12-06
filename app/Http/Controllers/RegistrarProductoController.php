<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class RegistrarProductoController extends Controller
{
    private $productoService;

    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

    public function mostrarFormulario()
    {
        $productos = $this->productoService->obtenerProductos();

        return view('productos.registrar-producto', [
            'productos' => $productos
        ]);
    }

    public function registrarProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'stockMinimo' => 'required|integer|min:0',
            'stockMaximo' => 'required|integer|min:0',
            'stockActual' => 'required|integer|min:0',
            'idCategoria' => 'required|integer|min:1',
            'idProveedor' => 'required|integer|min:1'
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.min' => 'El precio debe ser mayor a 0.',
            'stock.required' => 'El stock es obligatorio.',
            'stockMinimo.required' => 'El stock mínimo es obligatorio.',
            'stockMaximo.required' => 'El stock máximo es obligatorio.',
            'stockActual.required' => 'El stock actual es obligatorio.',
            'idCategoria.required' => 'La categoría es obligatoria.',
            'idProveedor.required' => 'El proveedor es obligatorio.'
        ]);

        $producto = [
            "nombre" => $request->input('nombre'),
            "precio" => $request->input('precio'),
            "stock" => $request->input('stock'),
            "stockMinimo" => $request->input('stockMinimo'),
            "stockMaximo" => $request->input('stockMaximo'),
            "stockActual" => $request->input('stockActual'),
            "idCategoria" => $request->input('idCategoria'),
            "idProveedor" => $request->input('idProveedor'),
            "estado" => "1"
        ];

        $resultado = $this->productoService->agregarProducto($producto);

        if ($resultado["success"]) {
            return redirect()->back()->with('success', 'Producto agregado correctamente.');
        } else {
            return redirect()->back()->with('error', "Error: {$resultado['error']}");
        }
    }
}