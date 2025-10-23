@extends('plantillas.inicio')

@section('h1', 'Actualizar Foto del Producto de Ave')

@section('contenido')
<div class="form-box">
    <form action="{{ route('fotoaves.update', $fotoAve->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Imagen actual --}}
        <div class="form-group text-center">
            <label>Foto actual</label><br>
            @if($fotoAve->nombrefoto)
                <img src="{{ asset('imagenes/aves/' . $fotoAve->nombrefoto) }}" 
                     alt="Foto actual" width="200" class="rounded shadow">
            @else
                <p class="text-muted">No hay imagen disponible.</p>
            @endif
        </div>

        {{-- Nueva imagen --}}
        <div class="form-group">
            <label>Nueva foto</label>
            <input type="file" name="nombrefoto" accept="image/*" required>
        </div>

        {{-- Botones --}}
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar Foto</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
