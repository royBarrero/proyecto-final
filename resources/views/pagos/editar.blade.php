@extends('plantillas.inicio')
@section('h1','Editar Pago')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('editar_pagos'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <form action="{{ route('pagos.update',$pago->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" value="{{ old('fecha',$pago->fecha) }}" required>
        </div>
        <div class="form-group">
            <label>Monto</label>
            <input type="number" name="monto" step="0.01" value="{{ old('monto',$pago->monto) }}" required>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado" required>
                <option value="1" {{ $pago->estado == 1 ? 'selected' : '' }}>Pagado</option>
                <option value="0" {{ $pago->estado == 0 ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pedido</label>
            <select name="idpedidos" required>
                @foreach($pedidos as $pedido)
                    <option value="{{ $pedido->id }}" {{ $pago->idpedidos == $pedido->id ? 'selected' : '' }}>
                        {{ $pedido->id }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Método de Pago</label>
            <select name="idmetodopagos" required>
                @foreach($metodos as $metodo)
                    <option value="{{ $metodo->id }}" {{ $pago->idmetodopagos == $metodo->id ? 'selected' : '' }}>
                        {{ $metodo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('pagos.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
