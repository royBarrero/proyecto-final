@extends('plantillas.inicio')

@section('h1', 'Bitácora')

@section('contenido')
    <div class="container">
        <h2>Lista de Auditorías</h2>
        <x-alerta />

        <div class="div-botones2" style="margin-bottom: 15px;">
            <form action="{{ route('auditorias.destroyAll') }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-eliminar"
                    onclick="return confirm('¿Eliminar toda la bitácora? Esta acción es irreversible.')">Eliminar
                    Todo</button>
            </form>
        </div>
        <div class="div-botones2">
            <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
        </div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tabla</th>
                    <th>Registro ID</th>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Cambios</th>
                    <th>Fecha</th>
                    <th>IP</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($auditorias as $audit)
                    <tr>
                        <td data-label="ID">{{ $audit->id }}</td>
                        <td data-label="Tabla">{{ $audit->tabla }}</td>
                        <td data-label="Registro ID">{{ $audit->registro_id }}</td>

                        {{-- Acción con color --}}
                        <td data-label="Acción">
                            @php
                                $color = match ($audit->accion) {
                                    'CREAR' => 'green',
                                    'ACTUALIZAR' => 'blue',
                                    'ELIMINAR' => 'red',
                                    'INICIO_SESION' => 'limegreen',
                                    'CIERRE_SESION' => 'orange',
                                    'INTENTO_FALLIDO' => 'crimson',
                                    default => 'black',
                                };
                            @endphp
                            <span style="color: {{ $color }}; font-weight:bold;">
                                {{ $audit->accion }}
                            </span>
                        </td>

                        {{-- Usuario --}}
                        <td data-label="Usuario">
                            {{ $audit->usuario?->nombre ?? 'Sistema' }}
                        </td>

                        {{-- Cambios --}}
                        <td data-label="Cambios" >
                            @php
                                $cambios = is_array($audit->cambios)
                                    ? $audit->cambios
                                    : json_decode($audit->cambios, true);
                                $mostrar = [];

                                if ($cambios) {
                                    switch ($audit->accion) {
                                        case 'ACTUALIZAR':
                                            if (isset($cambios['antes'], $cambios['despues'])) {
                                                foreach ($cambios['despues'] as $campo => $valor) {
                                                    $antes = $cambios['antes'][$campo] ?? null;
                                                    $despues = $valor;
                                                    if ((string) $antes !== (string) $despues) {
                                                        $mostrar[$campo] = "{$antes} → {$despues}";
                                                    }
                                                }
                                            }
                                            break;
                                        case 'CREAR':
                                            $mostrar = $cambios['despues'] ?? [];
                                            break;
                                        case 'ELIMINAR':
                                            $mostrar = $cambios['antes'] ?? [];
                                            break;
                                    }
                                }
                            @endphp

                            @if ($mostrar)
                                <ul style="margin:0; padding-left:16px; font-size:12px; list-style:none;">
                                    @foreach ($mostrar as $campo => $valor)
                                        <li><b>{{ $campo }}:</b> {{ $valor }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em style="color: #888;">Sin cambios registrados</em>
                            @endif
                        </td>


                        {{-- Fecha --}}
                        <td data-label="Fecha">
                            {{ \Carbon\Carbon::parse($audit->created_at)->format('d/m/Y H:i:s') }}
                        </td>

                        {{-- IP --}}
                        <td data-label="IP">{{ $audit->ip ?? 'Desconocida' }}</td>

                        {{-- Botón eliminar --}}
                        <td data-label="Acciones">
                            <form action="{{ route('auditorias.destroy', $audit->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar"
                                    onclick="return confirm('¿Eliminar este registro de auditoría?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="div-botones2">
            <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
        </div>
        <div style="margin-top: 15px;">
            {{ $auditorias->links() }}
        </div>
    </div>
@endsection
