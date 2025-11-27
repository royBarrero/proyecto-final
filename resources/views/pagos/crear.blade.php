@extends('plantillas.inicio')
@section('h1','Nuevo Pago')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('crear_pagos'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <form action="{{ route('pagos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" required>
        </div>
        <div class="form-group">
            <label>Monto</label>
            <input type="number" name="monto" step="0.01" required>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado" required>
                <option value="1">Pagado</option>
                <option value="0">Pendiente</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pedido</label>
            <select name="idpedidos" required>
                @foreach($pedidos as $pedido)
                    <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Método de Pago</label>
            <select name="idmetodopagos" required>
                @foreach($metodos as $metodo)
                    <option value="{{ $metodo->id }}">{{ $metodo->descripcion }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('pagos.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
