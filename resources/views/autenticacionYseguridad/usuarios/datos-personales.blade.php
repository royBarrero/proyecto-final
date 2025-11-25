@extends('plantillas.inicio')

@section('h1', 'Mis Datos Personales')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_usuarios'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="container">
    <h2>Información Personal</h2>
    <div class="info-box" style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
        <p><strong>ID:</strong> {{ auth()->user()->id }}</p>
        <p><strong>Nombre:</strong> {{ auth()->user()->nombre }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Rol:</strong> {{ auth()->user()->rol->descripcion ?? 'Sin rol' }}</p>
        <p><strong>Dirección:</strong> {{ auth()->user()->direccion ?? 'No especificada' }}</p>
        <p><strong>Teléfono:</strong> {{ auth()->user()->telefono ?? 'No especificado' }}</p>
    </div>

    <div class="div-botones2" style="margin-top:20px;">
        <a href="{{ route('editar.usuario', auth()->user()->id) }}" class="btn-editar">Editar</a>
        <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
    </div>
</div>
@endsection
