@extends('plantillas.inicio')
@section('h1', 'Auditoría del Sistema')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_auditoria'))
        <div class="alert alert-danger">Solo administradores pueden ver la auditoría.</div>
        @php abort(403); @endphp
    @endif

    <h2>Bitácora de Auditoría</h2>
    <x-alerta />
    
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Tabla</th>
                <th>Fecha</th>
                @if(auth()->user()->tienePermiso('eliminar_auditoria'))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($auditorias ?? [] as $auditoria)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Usuario">{{ $auditoria->usuario->nombre ?? 'N/A' }}</td>
                <td data-label="Acción">{{ $auditoria->accion }}</td>
                <td data-label="Tabla">{{ $auditoria->tabla }}</td>
                <td data-label="Fecha">{{ \Carbon\Carbon::parse($auditoria->fecha)->format('d/m/Y H:i:s') }}</td>
                
                @if(auth()->user()->tienePermiso('eliminar_auditoria'))
                <td data-label="Acciones">
                    <form action="{{ route('auditorias.destroy', $auditoria->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('eliminar_toda_auditoria'))
            <form action="{{ route('auditorias.destroyAll') }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar TODOS los registros?')">
                    Eliminar Todo
                </button>
            </form>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-cerrar">Volver</a>
    </div>
</div>
@endsection
