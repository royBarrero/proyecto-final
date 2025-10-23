@extends('plantillas.inicio')
@section('h1','Nuevo Proveedor')

@section('contenido')
<div class="form-box">
    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}">
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}">
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
