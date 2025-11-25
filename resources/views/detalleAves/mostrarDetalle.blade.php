mostrar detalladamente@extends('plantillas.inicio')
@section('h1','Detalle del Ave')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_detalle_aves'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <div class="form-group">
        <label><strong>ID:</strong></label>
        <p>{{ $detalleAve->id }}</p>
    </div>

    <div class="form-group">
        <label><strong>Descripción:</strong></label>
        <p>{{ $detalleAve->descripcion }}</p>
    </div>

    <div class="form-group">
        <label><strong>Edad:</strong></label>
        <p>{{ $detalleAve->edad }}</p>
    </div>

    <div class="form-group" style="display:flex; gap:10px;">
        <a href="{{ route('detalleAves.edit', $detalleAve->id) }}" class="btn">Editar</a>
        <a href="{{ route('detalleAves.index') }}" class="btn btn-cerrar">Volver</a>
    </div>
</div>
@endsection