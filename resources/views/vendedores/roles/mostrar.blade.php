@extends('plantillas.inicio')
@section('h1','Roles')

@section('contenido')
<div class="container">
    <h2>Lista de Roles</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($roles ?? [] as $rol)
            <tr>
                <td data-label="ID">{{ $rol->id }}</td>
                <td data-label="Descripcion">{{ $rol->descripcion }}</td>
                <td data-label="Aciones">
                    <div class="div-botones">
                        <a href="{{ route('rols.edit',$rol->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('rols.destroy',$rol->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este rol?\nTipo de Rol: {{ $rol->descripcion }}')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-botones2">
        <a href="{{ route('rols.create') }}" class="btn-editar">Nuevo Rol</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
