@extends('plantillas.inicio')
@section('h1','Nuevo Detalle de Ave')

@section('contenido')
<div class="form-box">
    <form action="{{ route('detalleaves.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Descripción (Especie)</label>
            <input type="text" name="descripcion" required>
        </div>

        <div class="form-group">
            <label>Edad (en días)</label>
            <input type="text" name="edad" required>
        </div>

        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
