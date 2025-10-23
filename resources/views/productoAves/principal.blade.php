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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
        @foreach($aves ?? [] as $producto)
            <tr>
                <td data-label="ID">{{ ++$i}}</td>
                <td data-label="Nombre">{{ $producto->nombre }}</td>
                <td data-label="Precio">{{ number_format($producto->precio, 2) }}</td>
                <td data-label="Categoría">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                <td data-label="Detalle Ave">{{ $producto->detalleAve->descripcion ?? 'Sin detalle' }}</td>
                <td data-label="Cantidad">{{ $producto->cantidad }}</td>
                <td data-label="Acciones">
                    <div class="div-botones">
                        <a href="{{ route('productoaves.show', $producto->id) }}" class="btn-editar">Ver</a>
                        <a href="{{ route('productoaves.edit', $producto->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('productoaves.destroy', $producto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?\n{{ $producto->nombre }}')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        <a href="{{ route('productoaves.create') }}" class="btn-editar">Nuevo Producto</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
