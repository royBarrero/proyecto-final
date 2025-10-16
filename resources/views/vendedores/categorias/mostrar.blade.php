@extends('plantillas.inicio')
@section('h1','Categorías')

@section('contenido')
<div class="container">
    <h2>Lista de Categorías</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categorias ?? [] as $categoria)
            <tr>
                <td data-label="ID">{{ $categoria->id }}</td>
                <td data-label="Nombre">{{ $categoria->nombre }}</td>
                <td data-label="Descripción">{{ $categoria->descripcion }}</td>
                <td data-label="Acciones">
                    <div class="div-botones">
                        <a href="{{ route('categorias.edit',$categoria->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('categorias.destroy',$categoria->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        <a href="{{ route('categorias.create') }}" class="btn-editar">Nueva Categoría</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
