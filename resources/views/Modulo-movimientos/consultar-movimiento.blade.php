<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Movimientos - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styleconsultarmovimiento.css') }}">
</head>
<body>

  <div class="container">

  <div class="volver">
      <a href="{{ route('modulo.movimiento') }}" class="btn-volver">
      Volver al panel
      </a>
    </div>

    <h1 class="titulo">
      <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" fill="currentColor" class="icon">
        <path fill-rule="evenodd" d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a..."/>
      </svg>
      Historial de Movimientos
    </h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- Mensaje de error --}}
    @if(isset($error) || session('error'))
      <div class="alert-error">
        {{ $error ?? session('error') }}
      </div>
    @endif

    <div class="tabla-container">
      <table class="tabla">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Acción</th>
            <th>ID Producto</th>
            <th>Eliminar</th>
          </tr>
        </thead>

        <tbody>
          @forelse($movimientos as $movimiento)
            <tr>
              <td>{{ $movimiento['id_movimiento'] }}</td>
              <td>{{ $movimiento['tipo'] }}</td>
              <td>{{ $movimiento['descripcion'] }}</td>
              <td>{{ $movimiento['cantidad'] }}</td>
              <td>{{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}</td>
              <td>{{ $movimiento['usuario_responsable'] }}</td>
              <td>{{ $movimiento['accion'] }}</td>
              <td>{{ $movimiento['id_producto'] ?? '—' }}</td>
              <td>
                <form action="{{ route('movimientos.eliminar') }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este movimiento?')">
                  @csrf
                  <input type="hidden" name="id" value="{{ $movimiento['id_movimiento'] }}">
                  <button type="submit" class="btn-delete">
                  Eliminar
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="no-data">No hay movimientos registrados</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>