<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Devoluciones - Invex</title>
  <link rel="stylesheet" href="{{ asset('css/styledevolucion.css') }}">
</head>
<body>

  <div class="container">

    <!-- Botón Volver arriba -->
    <div class="volver-arriba">
      <a href="{{ route('modulo.movimiento') }}" class="btn-volver">
      Volver al panel
      </a>
    </div>

    <!-- Título -->
    <h1 class="titulo">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="icon">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
      </svg>
      Registro de Devoluciones
    </h1>

    <!-- Mensajes -->
    @if(session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if(isset($error) || session('error'))
      <div class="alert-error">
        {{ $error ?? session('error') }}
      </div>
    @endif

    <!-- Formulario de registro/edición -->
    <div class="formulario-container">
      <h2 class="subtitulo" id="form-title">Registrar Nueva Devolución</h2>
      
      <form id="form-devolucion" action="{{ route('devoluciones.store') }}" method="POST" class="formulario-devolucion">
        @csrf
        <input type="hidden" id="devolucion-id" name="id">
        <input type="hidden" id="form-method" name="_method" value="POST">

        <div class="form-row">
          <div class="form-group">
            <label for="fechaDevolucion">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
              </svg>
              Fecha:
            </label>
            <input type="date" id="fechaDevolucion" name="fechaDevolucion" required>
          </div>

          <div class="form-group">
            <label for="cantidad">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                <path d="M9 2.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
              </svg>
              Cantidad:
            </label>
            <input type="number" id="cantidad" name="cantidad" min="1" placeholder="Ej: 5" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="idProducto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003z"/>
              </svg>
              ID Producto:
            </label>
            <input type="number" id="idProducto" name="idProducto" min="1" placeholder="Ej: 1" required>
          </div>

          <div class="form-group">
            <label for="idOrdenSalida">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8zm5 0 3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146a.5.5 0 0 1 .708-.708z"/>
              </svg>
              ID Orden Salida:
            </label>
            <input type="number" id="idOrdenSalida" name="idOrdenSalida" min="1" placeholder="Ej: 1" required>
          </div>
        </div>

        <div class="form-group full-width">
          <label for="motivo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg>
            Motivo:
          </label>
          <textarea id="motivo" name="motivo" placeholder="Describe el motivo de la devolución" rows="3" required></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit" id="btn-submit">
            <span id="btn-text">Registrar Devolución</span>
          </button>
          <button type="button" class="btn-cancel" id="btn-cancel" onclick="cancelarEdicion()" style="display: none;">
            Cancelar
          </button>
        </div>
      </form>
    </div>

    <!-- Tabla de devoluciones -->
    <div class="tabla-section">
      <h2 class="subtitulo">Historial de Devoluciones</h2>
      
      <div class="tabla-container">
        <table class="tabla">
          <thead>
            <tr>
              <th>ID</th>
              <th>Fecha</th>
              <th>Cantidad</th>
              <th>Motivo</th>
              <th>ID Producto</th>
              <th>ID Orden Salida</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($devoluciones as $devolucion)
              <tr>
                <td>{{ $devolucion['idDevolucion'] }}</td>
                <td>{{ \Carbon\Carbon::parse($devolucion['fechaDevolucion'])->format('d/m/Y') }}</td>
                <td>{{ $devolucion['cantidad'] }}</td>
                <td>{{ $devolucion['motivo'] }}</td>
                <td>{{ $devolucion['idProducto'] }}</td>
                <td>{{ $devolucion['idOrdenSalida'] }}</td>
                <td class="acciones">
                  <button onclick="editarDevolucion({{ json_encode($devolucion) }})" class="btn-edit">
                  Editar
                  </button>
                  
                  <form action="{{ route('devoluciones.destroy') }}" method="POST" style="display: inline;" 
                        onsubmit="return confirm('¿Estás seguro de eliminar esta devolución?')">
                    @csrf
                    <input type="hidden" name="id" value="{{ $devolucion['idDevolucion'] }}">
                    <button type="submit" class="btn-delete">
                    Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="no-data">No hay devoluciones registradas</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script>
    function editarDevolucion(devolucion) {
      // Cambiar título del formulario
      document.getElementById('form-title').textContent = 'Editar Devolución #' + devolucion.idDevolucion;
      
      // Cambiar acción del formulario
      document.getElementById('form-devolucion').action = "{{ route('devoluciones.update') }}";
      
      // Rellenar campos
      document.getElementById('devolucion-id').value = devolucion.idDevolucion;
      document.getElementById('fechaDevolucion').value = devolucion.fechaDevolucion;
      document.getElementById('cantidad').value = devolucion.cantidad;
      document.getElementById('idProducto').value = devolucion.idProducto;
      document.getElementById('idOrdenSalida').value = devolucion.idOrdenSalida;
      document.getElementById('motivo').value = devolucion.motivo;
      
      // Cambiar texto del botón
      document.getElementById('btn-text').textContent = 'Actualizar Devolución';
      document.getElementById('btn-cancel').style.display = 'inline-block';
      
      // Scroll al formulario
      document.querySelector('.formulario-container').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelarEdicion() {
      // Resetear formulario
      document.getElementById('form-devolucion').reset();
      document.getElementById('form-devolucion').action = "{{ route('devoluciones.store') }}";
      document.getElementById('devolucion-id').value = '';
      document.getElementById('form-title').textContent = 'Registrar Nueva Devolución';
      document.getElementById('btn-text').textContent = 'Registrar Devolución';
      document.getElementById('btn-cancel').style.display = 'none';
    }
  </script>

</body>
</html>