<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DevolucionesController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(10)->get('http://localhost:8080/devoluciones');
            
            if ($response->successful()) {
                $devoluciones = $response->json();
            } else {
                $devoluciones = [];
            }
            
        } catch (\Exception $e) {
            $devoluciones = [];
            $error = "Error al conectar con la API: " . $e->getMessage();
        }
        
        return view('Modulo-movimientos.registrar-devolucion', [
            'devoluciones' => $devoluciones,
            'error' => $error ?? null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'motivo' => 'required|string',
            'fechaDevolucion' => 'required|date',
            'idOrdenSalida' => 'required|integer',
            'idProducto' => 'required|integer'
        ]);

        try {
            $response = Http::asJson()->post('http://localhost:8080/devoluciones', [
                'cantidad' => (int)$request->cantidad,
                'motivo' => $request->motivo,
                'fechaDevolucion' => $request->fechaDevolucion,
                'idOrdenSalida' => (int)$request->idOrdenSalida,
                'idProducto' => (int)$request->idProducto
            ]);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('devoluciones.index')
                    ->with('success', 'Devolución registrada correctamente');
            }

            return redirect()->route('devoluciones.index')
                ->with('error', 'Error al registrar la devolución');

        } catch (\Exception $e) {
            return redirect()->route('devoluciones.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'cantidad' => 'required|integer',
            'motivo' => 'required|string',
            'fechaDevolucion' => 'required|date',
            'idOrdenSalida' => 'required|integer',
            'idProducto' => 'required|integer'
        ]);

        try {
            $id = $request->input('id');
            
            $response = Http::asJson()->put("http://localhost:8080/devoluciones/{$id}", [
                'cantidad' => (int)$request->cantidad,
                'motivo' => $request->motivo,
                'fechaDevolucion' => $request->fechaDevolucion,
                'idOrdenSalida' => (int)$request->idOrdenSalida,
                'idProducto' => (int)$request->idProducto
            ]);

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('devoluciones.index')
                    ->with('success', 'Devolución actualizada correctamente');
            }

            return redirect()->route('devoluciones.index')
                ->with('error', 'Error al actualizar');

        } catch (\Exception $e) {
            return redirect()->route('devoluciones.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            
            $response = Http::delete("http://localhost:8080/devoluciones/{$id}");

            if ($response->successful() || $response->status() == 200) {
                return redirect()->route('devoluciones.index')
                    ->with('success', 'Devolución eliminada correctamente');
            }

            return redirect()->route('devoluciones.index')
                ->with('error', 'Error al eliminar');

        } catch (\Exception $e) {
            return redirect()->route('devoluciones.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}