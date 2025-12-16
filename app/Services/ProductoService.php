<?php

namespace App\Services;

class ProductoService
{
    private string $apiUrl = "http://localhost:8080/productos";

    private function obtenerToken(): ?string
    {
        return session('token');
    }

    /* =========================
       GET PRODUCTOS
    ==========================*/
    public function obtenerProductos(): array
    {
        $token = $this->obtenerToken();
        if (!$token) return [];

        $curl = curl_init($this->apiUrl);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,               // 🔥 CLAVE
            CURLOPT_CONNECTTIMEOUT => 3,         // 🔥 CLAVE
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token
            ]
        ]);

        $respuesta = curl_exec($curl);

        if (curl_errno($curl)) {
            curl_close($curl);
            return [];
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) return [];

        return json_decode($respuesta, true) ?? [];
    }

    /* =========================
       PUT ACTUALIZAR PRODUCTO
    ==========================*/
    public function actualizarProducto(int $id, array $producto): array
    {
        $token = $this->obtenerToken();
        if (!$token) {
            return ["success" => false, "error" => "No hay sesión activa"];
        }

        $dataJson = json_encode($producto);

        $curl = curl_init($this->apiUrl . "/" . $id);

        curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $dataJson,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,               // 🔥 CLAVE
            CURLOPT_CONNECTTIMEOUT => 3,         // 🔥 CLAVE
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'Content-Length: ' . strlen($dataJson)
            ]
        ]);

        curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return ["success" => false, "error" => $error];
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return ($httpCode === 200)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $httpCode"];
    }
}
