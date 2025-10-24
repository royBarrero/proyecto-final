@extends('plantillas.inicio')

@section('h1', 'Galería de Fotos de Aves')

@section('botonesSesionCerrada')
    <div class="header-buttons">
        <a href="{{ route('acceso') }}">Iniciar Sesión</a>
        <a href="{{ route('registro') }}">Registrarse</a>
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
                <a href="{{ route('perfil') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Perfil</a>
            </li>
            <li>
                <form method="POST" action="{{ route('cerrarSesion') }}">
                    @csrf
                    <button type="submit" style="width:100%; text-align:left; padding:10px; border:none; background:none; cursor:pointer; color:#333;">Cerrar Sesión</button>
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
    <h2 style="margin-bottom:20px;">🐔Aves🐔</h2>
    @if(!$fotoaves->isEmpty())
        <div class="bird-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
            @foreach($fotoaves ?? [] as $foto)
                <div class="bird-card" style="border:1px solid #ddd; border-radius:10px; overflow:hidden; background:white;">
                    
                    <img src="{{ asset('storage/imagenes/'.$foto->nombrefoto) }}" alt="{{ $foto->nombrefoto }}" style="width:100%; height:180px; object-fit:cover;">

                    <div class="info" style="padding:10px;">
                        <h3 style="font-size:18px; margin:0 0 5px;">{{ $foto->productoAve->nombre }}</h3>
                        <p style="color:#666;">Precio: Bs {{ number_format($foto->productoAve->precio,2) }}</p>
                        <!-- Botón Añadir al carrito -->
                        <form method="POST" action="">
                        @csrf
                            <input type="hidden" name="producto_id" value="{{ $foto->productoAve->id }}">
                            <button type="submit" style="width:100%; padding:8px; background:#ef8504; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:bold; margin-top:10px;">
                                Añadir al carrito
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
            <p style="margin-top:20px; color:#666;">No hay fotos registradas aún.</p>
    @endif
</div>
<div class="container">
    <h2 style="margin-bottom:20px;">🥚Huevos de encubación🥚</h2>
    @if (!$fotohuevos->isEmpty())
    <div class="bird-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
        @foreach($fotohuevos ?? [] as $foto)
            <div class="bird-card" style="border:1px solid #ddd; border-radius:10px; overflow:hidden; background:white;">
                <img src="{{ asset('storage/imagenes/'.$foto->nombrefoto) }}" alt="{{ $foto->nombrefoto }}" style="width:100%; height:180px; object-fit:cover;">
                <div class="info" style="padding:10px;">
                    <h3 style="font-size:18px; margin:0 0 5px;">{{ $foto->productoAve->nombre }}</h3>
                    <p style="color:#666;">Precio: Bs {{ number_format($foto->productoAve->precio,2) }}</p>

                     <!-- Botón Añadir al carrito -->
                    <form method="POST" action="{{ route('carrito.agregar') }}">
                    @csrf
                        <input type="hidden" name="producto_id" value="{{ $foto->productoAve->id }}">
                        <button type="submit" style="width:100%; padding:8px; background:#ef8504; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:bold; margin-top:10px;">
                            Añadir al carrito
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <p style="margin-top:20px; color:#666;">No hay fotos registradas aún.</p>
    @endif
</div>
@endsection
