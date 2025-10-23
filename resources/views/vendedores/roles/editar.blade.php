@extends('plantillas.inicio')
@section('h1','Editar Rol')

@section('contenido')
<div class="form-box">
    <form action="{{ route('rols.update',$rol->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" value="{{ old('descripcion', $rol->descripcion ?? '') }}" required>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection

