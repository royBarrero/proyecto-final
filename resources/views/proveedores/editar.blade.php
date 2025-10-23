@extends('plantillas.inicio')
@section('h1','Editar Proveedor')

@section('contenido')
<div class="form-box">
    <form action="{{ route('proveedores.update',$proveedor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}">
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}">
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('proveedores.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
