@extends('plantillas.inicio')
@section('h1','Categorías')

@section('contenido')
<div class="container">
    <h2>Lista de usuarios</h2>

    {{-- Tabla para escritorio --}}
    <div class="tabla-escritorio">
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
            @foreach($usuarios ?? [] as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->correo }}</td>
                    <td>{{ $usuario->rol }}</td>
                    <td>{{ $usuario->direccion }}</td>
                    <td>{{ $usuario->telefono }}</td>
                    <td>
                        <div class="div-botones">
                            <a href="{{ route('editar.usuario',$usuario->id) }}" class="btn-editar">Editar</a>
                            <form action="{{ route('eliminar.usuario',$usuario->id) }}" method="POST" style="display:inline">
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
    </div>

    {{-- Grid de tarjetas para móviles --}}
    <div class="grid-usuarios">
        @foreach($usuarios ?? [] as $usuario)
            <div class="card-usuario">
                <p><strong>ID:</strong> {{ $usuario->id }}</p>
                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                <p><strong>Correo:</strong> {{ $usuario->correo }}</p>
                <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
                <p><strong>Dieccion:</strong> {{ $usuario->direccion }}</p>
                <p><strong>Telefono:</strong> {{ $usuario->telefono }}</p>
                <div class="div-botones">
                    <a href="{{ route('editar.usuario',$usuario->id) }}" class="btn-editar">Editar</a>
                    <form action="{{ route('eliminar.usuario',$usuario->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="div-botones2">
        <a href="{{ route('formularioParaCrearNuevoUsuario') }}" class="btn-editar">Nuevo usuario</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
