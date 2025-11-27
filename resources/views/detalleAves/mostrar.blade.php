@extends('plantillas.inicio')
@section('h1', 'Detalle de Aves')

@section('contenido')
<div class="container">
    <h2>Detalle de Aves - Razas y Edades</h2>
    <x-alerta />
    
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Raza / Especie</th>
                <th>Edad (días)</th>
                @if(auth()->user()->tieneAlgunPermiso(['editar_detalle_aves', 'eliminar_detalle_aves']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($detalleAves ?? [] as $detalle)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Raza">{{ $detalle->descripcion }}</td>
                <td data-label="Edad">{{ $detalle->edad }}</td>
                
                @if(auth()->user()->tieneAlgunPermiso(['editar_detalle_aves', 'eliminar_detalle_aves']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        <a href="{{ route('detalleAves.show', $detalle->id) }}" class="btn-editar">Ver</a>
                        
                        @if(auth()->user()->tienePermiso('editar_detalle_aves'))
                            <a href="{{ route('detalleAves.edit', $detalle->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        @if(auth()->user()->tienePermiso('eliminar_detalle_aves'))
                            <form action="{{ route('detalleAves.destroy', $detalle->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar {{ $detalle->descripcion }}?')">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('crear_detalle_aves'))
            <a href="{{ route('detalleaves.create') }}" class="btn-editar">Nuevo Detalle</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
