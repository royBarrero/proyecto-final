@extends('plantillas.inicio')
@section('h1','Editar Detalle de Ave')

@section('contenido')
<div class="form-box">
    <form action="{{ route('detalleaves.update',$detalleave->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Descripción (Especie)</label>
            <input type="text" name="descripcion" value="{{ old('descripcion', $detalleave->descripcion ?? '') }}" required>
        </div>

        <div class="form-group">
            <label>Edad (en días)</label>
            <input type="text" name="edad" value="{{ old('edad', $detalleave->edad ?? '') }}" required>
        </div>

        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
