@extends('plantillas.inicio')

@section('titulo', 'Editar Usuario')

@section('h1', 'Editar Usuario')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('editar_usuarios'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <h2>Editar Usuario</h2>

    <form action="{{ route('actualizarUsuario', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                value="{{ old('nombre', $usuario->nombre) }}" 
                required>
        </div>

        {{-- Correo --}}
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email', $usuario->correo) }}" 
                required>
        </div>

        {{-- Dirección (puede ser NULL) --}}
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input 
                type="text" 
                name="direccion" 
                id="direccion" 
                value="{{ old('direccion', $usuario->direccion) }}">
        </div>

        {{-- Teléfono (puede ser NULL) --}}
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input 
                type="text" 
                name="telefono" 
                id="telefono" 
                value="{{ old('telefono', $usuario->telefono) }}">
        </div>

        {{-- Contraseña (opcional cambiarla) 
        <div class="form-group">
            <label for="contrasenia">Contraseña (dejar en blanco si no desea cambiar)</label>
            <input 
                type="password" 
                name="contrasenia" 
                id="contrasenia" 
                placeholder="••••••••">
        </div>
--}}
        {{-- Rol --}}
        <div class="form-group">
    <label for="idrols">Rol</label>

    <div style="position:relative; display:inline-block; width:100%;">
        {{-- Botón que muestra el rol actual --}}
        <button type="button" id="rolMenuBtn" style="color:#ef8504; background:white; padding:10px; border-radius:5px; font-weight:bold; border:1px solid #ccc; cursor:pointer; width:100%; text-align:left;">
            {{ $usuario->rol ?? 'Seleccionar rol' }} ▼
        </button>

        {{-- Lista desplegable --}}
        <ul id="rolMenu" style="
            display:none;
            position:absolute;
            left:0;
            right:0;
            background:white;
            color:#333;
            list-style:none;
            padding:0;
            margin:0;
            border-radius:5px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            z-index:1000;">
            @foreach($roles as $rol)
                <li style="border-bottom:1px solid #eee;">
                    <a href="#" 
                       onclick="event.preventDefault(); seleccionarRol({{ $rol->id }}, '{{ addslashes($rol->descripcion) }}');"
                       style="display:block; padding:10px; text-decoration:none; color:#333;">
                        {{ $rol->descripcion }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Input oculto que enviará el rol seleccionado --}}
    <input type="hidden" name="idrols" id="idrols" value="{{ $rolIdUsuario }}">
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const boton = document.getElementById('rolMenuBtn');
    const menu = document.getElementById('rolMenu');
    const inputRol = document.getElementById('idrols');

    // Inicializar el texto del botón con el rol actual
    @if($rolIdUsuario)
        const rolActual = @json($roles->firstWhere('id', $rolIdUsuario)->descripcion);
        boton.innerText = rolActual + ' ▼';
    @endif

    boton.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        menu.style.display = 'none';
    });
});

// Función para seleccionar rol
function seleccionarRol(id, descripcion) {
    document.getElementById('idrols').value = id;
    document.getElementById('rolMenuBtn').innerText = descripcion + ' ▼';
    document.getElementById('rolMenu').style.display = 'none';
}
</script>



        {{-- Botones --}}
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Confirmar Cambios</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Cancelar</a>
        </div>
    </form>
</div>
@endsection

