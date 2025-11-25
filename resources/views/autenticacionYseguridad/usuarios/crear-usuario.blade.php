@extends('plantillas.inicio')

@section('titulo', 'Crear Usuario')

@section('h1', 'Crear Usuario')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('crear_usuarios'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <h2>Crear Usuario</h2>

    <form action="{{ route('crearNuevoUsuario') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                value="" 
                placeholder="Ingrese el nombre"
                required>
        </div>

        {{-- Correo --}}
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="" 
                placeholder="Ingrese el correo electrónico"
                required>
        </div>

        {{-- Dirección --}}
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input 
                type="text" 
                name="direccion" 
                id="direccion" 
                value="" 
                placeholder="Ingrese la dirección">
        </div>

        {{-- Teléfono --}}
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input 
                type="text" 
                name="telefono" 
                id="telefono" 
                value="" 
                placeholder="Ingrese el teléfono">
        </div>

        {{-- Contraseña --}}
        <div class="form-group" style="position:relative;">
            <label for="contrasenia">Contraseña</label>
            <input 
                type="password" 
                name="contrasenia" 
                id="contrasenia" 
                placeholder="••••••••" 
                required
                style="width:100%; padding-right:40px;">
                <span id="togglePassword" style="
                position:absolute; 
                right:10px; 
                top:50%; 
                transform:translateY(-50%); 
                cursor:pointer;
                font-size: 18px;
                ">
                👁️
            </span>
        </div>


        {{-- Rol --}}
        <div class="form-group">
            <label for="idrols">Rol</label>
            <div style="position:relative; display:inline-block; width:100%;">
                <button type="button" id="rolMenuBtn" style="color:#ef8504; background:white; padding:10px; border-radius:5px; font-weight:bold; border:1px solid #ccc; cursor:pointer; width:100%; text-align:left;">
                    Seleccionar rol ▼
                </button>

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
                               onclick="event.preventDefault(); seleccionarRol({{ $rol->id }}, '{{ $rol->descripcion }}');"
                               style="display:block; padding:10px; text-decoration:none; color:#333;">
                                {{ $rol->descripcion }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <input type="hidden" name="idrols" id="idrols" value="">
        </div>

        {{-- Scripts --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const boton = document.getElementById('rolMenuBtn');
                const menu = document.getElementById('rolMenu');

                boton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                });

                document.addEventListener('click', function() {
                    menu.style.display = 'none';
                });

                // Mostrar/ocultar contraseña
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('contrasenia');

                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                });
            });

            function seleccionarRol(id, descripcion) {
                document.getElementById('idrols').value = id;
                document.getElementById('rolMenuBtn').innerText = descripcion + ' ▼';
                document.getElementById('rolMenu').style.display = 'none';
            }
        </script>

        {{-- Botones --}}
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Crear Usuario</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
