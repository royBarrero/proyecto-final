@extends('plantillas.inicio')
@section('h1','Roles')

@section('contenido')
<div class="container">
    <h2>Lista de Roles</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                @if(auth()->user()->tieneAlgunPermiso(['editar_roles', 'eliminar_roles', 'gestionar_permisos']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @php
            $i=0;
        @endphp
        @foreach($roles ?? [] as $rol)
            <tr>
                <td data-label="ID">{{++$i }}</td>
                <td data-label="Descripcion">{{ $rol->descripcion }}</td>
                
                @if(auth()->user()->tieneAlgunPermiso(['editar_roles', 'eliminar_roles', 'gestionar_permisos']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        {{-- Gestionar Permisos: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('gestionar_permisos'))
                            <a href="{{ route('rols.gestionarPermisos', $rol) }}" class="btn-editar">Permisos</a>
                        @endif
                        
                        {{-- Editar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('editar_roles'))
                            <a href="{{ route('rols.edit',$rol->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        {{-- Eliminar: Solo Admin --}}
                        @if(auth()->user()->tienePermiso('eliminar_roles'))
                            <form action="{{ route('rols.destroy',$rol->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este rol?\nTipo de Rol: {{ $rol->descripcion }}')">Eliminar</button>
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
        {{-- Nuevo Rol: Solo Admin --}}
        @if(auth()->user()->tienePermiso('crear_roles'))
            <a href="{{ route('rols.create') }}" class="btn-editar">Nuevo Rol</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
