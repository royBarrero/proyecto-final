@extends('plantillas.inicio')
@section('h1','Usuarios')

@section('contenido')
<div class="container">
    <h2>Lista de usuarios</h2>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Aciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($usuarios ?? [] as $usuario)
                <tr>
                    <td data-label="ID">{{ $usuario->id }}</td>
                    <td data-label="Nombre">{{ $usuario->nombre }}</td>
                    <td data-label="Correo">{{ $usuario->correo }}</td>
                    <td data-label="Rol">{{ $usuario->rol }}</td>
                    <td data-label="Direccion">{{ $usuario->direccion }}</td>
                    <td data-label="Telefono">{{ $usuario->telefono }}</td>
                    <td data-label="Acciones">
                        <div class="div-botones">
                            <a href="{{ route('editar.usuario',$usuario->id) }}" class="btn-editar">Editar</a>
                            <form action="{{ route('eliminar.usuario',$usuario->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar a {{ $usuario->nombre }}?')">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    <div class="div-botones2">
        <a href="{{ route('formularioParaCrearNuevoUsuario') }}" class="btn-editar">Nuevo usuario</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
