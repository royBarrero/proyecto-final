@extends('plantillas.inicio')
@section('h1', 'Categorías')

@section('contenido')
<div class="container">
    <h2>Lista de Categorías</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                @if(auth()->user()->tieneAlgunPermiso(['editar_categorias', 'eliminar_categorias']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($categorias ?? [] as $categoria)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Nombre">{{ $categoria->nombre }}</td>
                <td data-label="Descripción">{{ $categoria->descripcion }}</td>
                
                @if(auth()->user()->tieneAlgunPermiso(['editar_categorias', 'eliminar_categorias']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        {{-- Editar: Vendedor y Admin --}}
                        @if(auth()->user()->tienePermiso('editar_categorias'))
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        {{-- Eliminar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('eliminar_categorias'))
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar categoría {{ $categoria->nombre }}?')">Eliminar</button>
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
        {{-- Nueva Categoría: Vendedor y Admin --}}
        @if(auth()->user()->tienePermiso('crear_categorias'))
            <a href="{{ route('categorias.create') }}" class="btn-editar">Nueva Categoría</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
