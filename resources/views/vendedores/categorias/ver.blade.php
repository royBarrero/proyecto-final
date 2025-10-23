@extends('plantillas.inicio')
@section('h1','Detalle de Categoría')

@section('contenido')
<div class="container">
    <h2>{{ $categoria->nombre }}</h2>
    <p>{{ $categoria->descripcion }}</p>
    <a href="{{ route('categorias.index') }}" class="btn-eliminar">Volver</a>
</div>
@endsection
