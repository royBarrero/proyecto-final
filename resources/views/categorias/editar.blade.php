@extends('plantillas.inicio')
@section('h1','Editar Categoría')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('editar_categorias'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <form action="{{ route('categorias.update',$categoria->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="textarea-controlado">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
