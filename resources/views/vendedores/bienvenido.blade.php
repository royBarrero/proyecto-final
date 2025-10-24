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
        <button 
            id="createBTN"
            onclick="window.location.href='{{ route('auditorias.index') }}'"
            style="color:#ef8504; background:white; padding:8px 15px; border-radius:5px; font-weight:bold; border:none; cursor:pointer; transition: all 0.2s ease-in-out;">
            @auth
                Bitácora
            @endauth
        </button>
    </div>
    <div style="position:relative; display:inline-block;">
        <button 
            id="createBTN"
            onclick="window.location.href='{{ route('proveedores.index') }}'"
            style="color:#ef8504; background:white; padding:8px 15px; border-radius:5px; font-weight:bold; border:none; cursor:pointer; transition: all 0.2s ease-in-out;">
            @auth
                Gestionar Proveedores
            @endauth
        </button>
    </div>
    <div style="position:relative; display:inline-block;">
        <button id="gestionarProductosBtn" style="color:#ef8504; background:white; padding:8px 15px; border-radius:5px; font-weight:bold; border:none; cursor:pointer;">
            @Auth
                Gestionar Productos ▼
            @endAuth
        </button>

        <ul id="gestionarProductosMenu" style="
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
                <a href="{{ route('productoaves.index') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Producto Aves</a>
            </li>
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('categorias.index') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">Categorias</a>
            </li>
            <li style="border-bottom:1px solid #eee;">
                <a href="{{ route('detalleaves.index') }}" style="display:block; padding:10px; text-decoration:none; color:#333;">detalle de aves</a>
            </li>
            
        </ul>
    </div>

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
            const menus = [
                { boton: 'gestionarProductosBtn', menu: 'gestionarProductosMenu' },
                { boton: 'userMenuBtn', menu: 'userMenu' }
            ];

            menus.forEach(({ boton, menu }) => {
                const btn = document.getElementById(boton);
                const ul = document.getElementById(menu);

                if (btn && ul) {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        menus.forEach(({ menu: otherMenu }) => {
                            if (otherMenu !== menu) {
                                const otherUl = document.getElementById(otherMenu);
                                if (otherUl) otherUl.style.display = 'none';
                            }
                        });
                        ul.style.display = (ul.style.display === 'block') ? 'none' : 'block';
                    });
                }
            });

            document.addEventListener('click', function () {
                menus.forEach(({ menu }) => {
                    const ul = document.getElementById(menu);
                    if (ul) ul.style.display = 'none';
                });
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
            @if(!$fotoaves->isEmpty())
                <div class="bird-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
                    @foreach($fotoaves ?? [] as $foto1)
                        <div class="bird-card" style="border:1px solid #ddd; border-radius:10px; overflow:hidden; background:white;">
                            <img src="{{ asset('storage/imagenes/'.$foto1->nombrefoto) }}" alt="{{ $foto1->nombrefoto }}" style="width:100%; height:180px; object-fit:cover;">
                                <div class="info" style="padding:10px;">
                                <h3 style="font-size:18px; margin:0 0 5px;">{{ $foto1->productoAve->nombre }}</h3>
                                <p style="color:#666;">Precio: Bs {{ number_format($foto1->productoAve->precio,2) }}</p>
                                <div class="div-botones2">
                                    <a href="{{ route('fotoaves.edit',$foto1->id)}}" class="btn-editar">editar</a>
                                    <form action="{{ route('fotoaves.destroy', $foto1->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?\nTipo de ave: {{ $foto1->descripcion }}')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="margin-top:20px; color:#666;">No hay fotos registradas aún.</p>
            @endif
        </div>
    </div>

    <!-- Patos -->
    <div class="category">
        <h2>🥚 Huevos 🥚</h2>
        <div class="bird-grid">
            @if(!$fotohuevos->isEmpty())
                <div class="bird-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:20px;">
                    @foreach($fotohuevos ?? [] as $foto)
                        <div class="bird-card" style="border:1px solid #ddd; border-radius:10px; overflow:hidden; background:white;">
                            <img src="{{ asset('storage/imagenes/'.$foto->nombrefoto) }}" alt="{{ $foto->nombrefoto }}" style="width:100%; height:180px; object-fit:cover;">
                                <div class="info" style="padding:10px;">
                                <h3 style="font-size:18px; margin:0 0 5px;">{{ $foto->productoAve->nombre }}</h3>
                                <p style="color:#666;">Precio: Bs {{ number_format($foto->productoAve->precio,2) }}</p>
                                <div class="div-botones2">
                                    <a href="" class="btn-editar" >Ver más</a>
                        
                                    <a href="" class="btn-editar">editar</a>
                                    <form action="{{ route('fotoaves.destroy', $foto->id) }}" method="POST" style="display: inline;">
                                    @csrf        
                                    @method('DELETE')
                                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?\nTipo de ave: {{ $foto->descripcion }}')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="margin-top:20px; color:#666;">No hay fotos registradas aún.</p>
            @endif
        </div>
    </div>

    <!-- Agrega más categorías como Faisanes, Pavos Reales, Palomas, etc. -->

</div>
@endsection

