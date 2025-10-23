@extends('plantillas.inicio')

@section('h1','Bitácora')

@section('contenido')
<div class="container">
    <h2>Lista de Auditorías</h2>
    <x-alerta />

    <div class="div-botones2" style="margin-bottom: 15px;">
        <form action="{{ route('auditorias.destroyAll') }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar toda la bitácora? Esta acción es irreversible.')">Eliminar Todo</button>
        </form>
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($auditorias as $audit)
            <tr>
                <td data-label="ID">{{ $audit->id }}</td>
                <td data-label="Tabla">{{ $audit->tabla }}</td>
                <td data-label="Registro ID">{{ $audit->registro_id }}</td>
                <td data-label="Acción">{{ $audit->accion }}</td>
                <td data-label="Usuario">{{ $audit->usuario_id }}</td>
                <td data-label="Cambios"><pre>{{ json_encode(json_decode($audit->cambios), JSON_PRETTY_PRINT) }}</pre></td>
                <td data-label="Fecha">{{ $audit->created_at }}</td>
                <td data-label="Acciones">
                    <form action="{{ route('auditorias.destroy', $audit->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este registro de auditoría?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        {{ $auditorias->links() }}
    </div>
</div>
@endsection

