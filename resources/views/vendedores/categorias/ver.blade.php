@extends('plantillas.inicio')
@section('h1','Detalle de Categoría')

@section('contenido')
<div class="container">
    <h2>{{ $categoria->nombre }}</h2>
    <p>{{ $categoria->descripcion }}</p>
    <a href="{{ url()->previous() }}" class="btn-eliminar">Volver</a>
</div>
@endsection
