@extends('plantillas.inicio')
@section('h1', 'Productos de Aves')

@section('contenido')
<div class="container">
    <h2>Lista de Productos de Aves</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio (Bs)</th>
                <th>Categoría</th>
                <th>Detalle Ave</th>
                <th>Cantidad</th>
                @if(auth()->user()->tieneAlgunPermiso(['ver_productos', 'editar_productos', 'eliminar_productos']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($aves ?? [] as $producto)
            <tr>
                <td data-label="ID">{{ ++$i}}</td>
                <td data-label="Nombre">{{ $producto->nombre }}</td>
                <td data-label="Precio">{{ number_format($producto->precio, 2) }}</td>
                <td data-label="Categoría">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                <td data-label="Detalle Ave">{{ $producto->detalleAve->descripcion ?? 'Sin detalle' }}</td>
                <td data-label="Cantidad">{{ $producto->cantidad }}</td>
                
                @if(auth()->user()->tieneAlgunPermiso(['ver_productos', 'editar_productos', 'eliminar_productos']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        {{-- Ver: Todos los que tienen permiso ver_productos --}}
                        @if(auth()->user()->tienePermiso('ver_productos'))
                            <a href="{{ route('productoaves.show', $producto->id) }}" class="btn-editar">Ver</a>
                        @endif
                        
                        {{-- Editar: Solo Vendedor y Admin --}}
                        @if(auth()->user()->tienePermiso('editar_productos'))
                            <a href="{{ route('productoaves.edit', $producto->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        {{-- Eliminar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('eliminar_productos'))
                            <form action="{{ route('productoaves.destroy', $producto->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?\n{{ $producto->nombre }}')">Eliminar</button>
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
        {{-- Nuevo Producto: Solo Vendedor y Admin --}}
        @if(auth()->user()->tienePermiso('crear_productos'))
            <a href="{{ route('productoaves.create') }}" class="btn-editar">Nuevo Producto</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection