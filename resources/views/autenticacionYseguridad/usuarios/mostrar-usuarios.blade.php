@extends('plantillas.inicio')
@section('h1','Usuarios')

@section('contenido')
<div class="container">
    <h2>Lista de usuarios</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Direccion</th>
                <th>Telefono</th>
                @if(auth()->user()->tieneAlgunPermiso(['editar_usuarios', 'eliminar_usuarios']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($usuarios ?? [] as $usuario)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Nombre">{{ $usuario->nombre }}</td>
                <td data-label="Correo">{{ $usuario->correo }}</td>
                <td data-label="Rol">{{ $usuario->rol }}</td>
                <td data-label="Direccion">{{ $usuario->direccion }}</td>
                <td data-label="Telefono">{{ $usuario->telefono }}</td>
                
                @if(auth()->user()->tieneAlgunPermiso(['editar_usuarios', 'eliminar_usuarios']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        {{-- Editar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('editar_usuarios'))
                            <a href="{{ route('editar.usuario',$usuario->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        {{-- Eliminar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('eliminar_usuarios'))
                            <form action="{{ route('eliminar.usuario',$usuario->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar a {{ $usuario->nombre }}?')">Eliminar</button>
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
        {{-- Nuevo Usuario: Solo Admin --}}
        @if(auth()->user()->tienePermiso('crear_usuarios'))
            <a href="{{ route('formularioParaCrearNuevoUsuario') }}" class="btn-editar">Nuevo usuario</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection