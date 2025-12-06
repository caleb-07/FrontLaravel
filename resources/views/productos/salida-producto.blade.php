<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de Productos - Punto Éxito</title>
    <link rel="stylesheet" href="{{ asset('css/styleproductos.css') }}">
</head>
<body>
    <header>
        <h1>Salida de Productos</h1>
    </header>

    <main>
        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <p style='color:green; background-color: #1b4d1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #2d7a2d;'>
                {!! session('success') !!}
            </p>
        @endif

        @if(session('error'))
            <p style='color:red; background-color: #4d1b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #7a2d2d;'>
                {{ session('error') }}
            </p>
        @endif

        @if($errors->any())
            <div style='color:red; background-color: #4d1b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; border: 1px solid #7a2d2d;'>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>Registrar Salida (Venta)</h2>

        <form method="POST" action="{{ route('productos.salida.registrar') }}">
            @csrf
            <label for="idProducto">Selecciona un producto:</label>
            <select name="idProducto" id="idProducto" required onchange="mostrarInfoProducto()">
                <option value="">-- Selecciona un producto --</option>
                @if(count($productos) > 0)
                    @foreach($productos as $producto)
                        <option value="{{ $producto['idProducto'] }}" 
                                data-nombre="{{ htmlspecialchars($producto['nombre']) }}"
                                data-precio="{{ $producto['precio'] }}"
                                data-stockactual="{{ $producto['stockActual'] }}"
                                data-stockminimo="{{ $producto['stockMinimo'] }}">
                            {{ htmlspecialchars($producto['nombre']) }} - Stock: {{ $producto['stockActual'] }}
                        </option>
                    @endforeach
                @endif
            </select>

            <div id="infoProducto" style="display: none; background-color: #2b2b3d; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #555;">
                <p><b>Producto:</b> <span id="infoNombre"></span></p>
                <p><b>Precio:</b> $<span id="infoPrecio"></span></p>
                <p><b>Stock Disponible:</b> <span id="infoStockActual"></span></p>
                <p><b>Stock Mínimo:</b> <span id="infoStockMinimo"></span></p>
            </div>

            <label for="cantidadRetirar">Cantidad a vender/retirar:</label>
            <input type="number" name="cantidadRetirar" id="cantidadRetirar" min="1" required>

            <button type="submit">Confirmar Salida</button>
        </form>

        <h2>Productos Disponibles</h2>
        @if(count($productos) > 0)
            <ul>
                @foreach($productos as $producto)
                    <li>
                        <b>ID:</b> {{ htmlspecialchars($producto["idProducto"]) }} | 
                        <b>Nombre:</b> {{ htmlspecialchars($producto["nombre"]) }} | 
                        <b>Precio:</b> ${{ number_format($producto["precio"], 2) }} | 
                        <b>Stock Actual:</b> {{ htmlspecialchars($producto["stockActual"]) }} | 
                        <b>Stock Min:</b> {{ htmlspecialchars($producto["stockMinimo"]) }}
                        @if($producto['stockActual'] < $producto['stockMinimo'])
                            <span style="color: #ff6b6b; font-weight: bold;">  STOCK BAJO</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#999;">No hay productos activos disponibles.</p>
        @endif

        <div class="volver">
            <a href="{{ route('productos.gestion') }}">Volver al módulo</a>
        </div>
    </main>

    <footer>
        <p>© 2025 Punto Éxito. Todos los derechos reservados.</p>
    </footer>

    <script>
        function mostrarInfoProducto() {
            const select = document.getElementById('idProducto');
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                document.getElementById('infoNombre').textContent = option.dataset.nombre;
                document.getElementById('infoPrecio').textContent = option.dataset.precio;
                document.getElementById('infoStockActual').textContent = option.dataset.stockactual;
                document.getElementById('infoStockMinimo').textContent = option.dataset.stockminimo;
                document.getElementById('infoProducto').style.display = 'block';
            } else {
                document.getElementById('infoProducto').style.display = 'none';
            }
        }
    </script>
</body>
</html>