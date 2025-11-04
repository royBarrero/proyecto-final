@extends('plantillas.inicio')

@section('h1', 'Galería de Fotos de Aves')

@section('botonesSesionCerrada')
    <div class="header-buttons">
        <a href="{{ route('acceso') }}">{{__('Iniciar Sesión')}}</a>
        <a href="{{ route('registro') }}">{{__('Registrarse')}}</a>
    </div>
@endsection

@section('contenido')
<div class="container">
    <h2 style="margin-bottom:20px;">🐔{{__('Aves')}}🐔</h2>
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
