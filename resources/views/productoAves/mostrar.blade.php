@extends('plantillas.inicio')
@section('h1', 'Detalles del Producto de Ave')

@section('contenido')
<div class="container">
    <h2>Información del Producto</h2>
    <div class="info-box" style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
        <p><strong>ID:</strong> {{ $productoAve->id }}</p>
        <p><strong>Nombre:</strong> {{ $productoAve->nombre }}</p>
        <p><strong>Precio:</strong> Bs {{ number_format($productoAve->precio, 2) }}</p>
        <p><strong>Categoría:</strong> {{ $productoAve->categoria->nombre ?? 'Sin categoría' }}</p>
        <p><strong>Detalle del Ave:</strong> {{ $productoAve->detalleAve->descripcion ?? 'Sin detalle' }} ({{ $productoAve->detalleAve->edad ?? 'N/A' }} días)</p>
        <p><strong>Cantidad:</strong> {{ $productoAve->cantidad }}</p>
    </div>
    <div class="div-botones2" style="margin-top:20px;">
        <a href="{{ route('productoaves.edit', $productoAve->id) }}" class="btn-editar">Editar</a>
        <a href="{{ url()->previous() }}" class="btn btn-cerrar">Volver</a>
    </div>
</div>
@endsection

