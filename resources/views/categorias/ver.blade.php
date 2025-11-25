@extends('plantillas.inicio')
@section('h1','Detalle de Categoría')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_categorias'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="container">
    <h2>{{ $categoria->nombre }}</h2>
    <p>{{ $categoria->descripcion }}</p>
    <a href="{{ url()->previous() }}" class="btn-eliminar">Volver</a>
</div>
@endsection
