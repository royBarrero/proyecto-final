@extends('plantillas.inicio')


@section('h1', 'Catálogo de Aves')

@section('botonesSesionCerrada')
    <div class="header-buttons">
        <a href="{{route('acceso')}}">Iniciar Sesión</a>
        <a href="{{route('registro')}}">Registrarse</a>
    </div>
@endsection

@section('botonesSesionAbierta')
    <div style="position:relative; display:inline-block;">
        <button id="userMenuBtn" style="color:#ef8504; background:white; padding:8px 15px; border-radius:5px; font-weight:bold; border:none; cursor:pointer;">
            @Auth
                {{ Auth::user()->nombre ?? Auth::user()->email }} ▼
            @endAuth
        </button>

        <ul id="userMenu" style="
            display:none;
            position:absolute;
            right:0;
            background:white;
            color:#333;
            list-style:none;
            padding:0;
            margin:0;
            border-radius:5px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            min-width:150px;
            z-index:1000;">
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('mostrarDatosPersonales') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Perfil</a>
            </li>
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('mostrarDatosDeTodosLosUsuarios') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">ver usuarios</a>
            </li>
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('categorias.index') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Categorías</a>
            </li>
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('rols.index') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">roles</a>
            </li>
            <li>
                <form method="POST" action="{{ route('cerrarSesion') }}">
                @csrf
                    <button type="submit" style="width:100%; text-align:center; padding:10px; border:none; background:none; cursor:pointer; color:#333; font-weight: 510; font-size: 16px;">Cerrar Sesión</button>
                </form>
            </li>
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const boton = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userMenu');

            boton.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            });

            document.addEventListener('click', function() {
                menu.style.display = 'none';
            });
        });
    </script>
@endsection

@section('contenido')
<div class="container">

    <!-- Gallinas -->
    <div class="category">
        <h2>🐔 Pollitos</h2>
        <div class="bird-grid">
            @for ($i = 0; $i < 10; $i++)
                <div class="bird-card">
                <img src="https://via.placeholder.com/300x150" alt="Gallina Autóctona">
                <div class="info">
                    <h3>Gallina Autóctona</h3>
                    <p>Especie local adaptada a nuestro clima y condiciones.</p>
                </div>
                @auth
                    @if (auth::user()->idrols==1)
                        <div class="header-buttons" style="display:flex; gap:10px;">
                            <a href="{{ route('productoAves.index') }}" >Ver más</a>
                        </div>
                    @endif
                @endauth
            </div>
            @endfor
            
            <!-- Agrega más aves aquí -->
        </div>
    </div>

    <!-- Patos -->
    <div class="category">
        <h2>🥚 Huevos</h2>
        <div class="bird-grid">
            @for ($i = 0; $i < 5; $i++)
                <div class="bird-card">
                <img src="https://via.placeholder.com/300x150" alt="Gallina Autóctona">
                <div class="info">
                    <h3>Gallina Autóctona</h3>
                    <p>Especie local adaptada a nuestro clima y condiciones.</p>
                </div>
                @auth
                    @if (auth::user()->idrols==1)
                        <div class="header-buttons" style="display:flex; gap:10px;">
                            <a href="{{ route('formularioParaCrearNuevoUsuario') }}" >Ver más</a>
                        </div>
                    @endif
                @endauth
            </div>
            @endfor
            <!-- Agrega más patos aquí -->
        </div>
    </div>

    <!-- Agrega más categorías como Faisanes, Pavos Reales, Palomas, etc. -->

</div>
@endsection

