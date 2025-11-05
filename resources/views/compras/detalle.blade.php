@extends('plantillas.inicio')

@section('h1', 'Detalle de compra')

@section('contenido')
<div class="container">

    <div style="margin-bottom:20px;">
        <a href="{{ route('compras.index') }}" style="padding:8px 15px; background:#ef8504; color:white; border-radius:5px; text-decoration:none; font-weight:bold;">← Volver a compras</a>
    </div>

    <div style="border:1px solid #ddd; padding:15px; border-radius:10px; margin-bottom:20px; background:white;">
        <p><strong>ID Compra:</strong> {{ $compra->id }}</p>
        <p><strong>Fecha:</strong> {{ $compra->fecha }}</p>
        <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
        <p><strong>Estado:</strong> {{ $compra->estado }}</p>
    </div>

    <h3 style="margin-bottom:10px;">Productos adquiridos</h3>

    @if($compra->detalles->isEmpty())
        <p>No hay productos en esta compra.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#ef8504; color:white;">
                    <th style="padding:10px; border:1px solid #ddd;">Producto</th>
                    <th style="padding:10px; border:1px solid #ddd;">Cantidad</th>
                    <th style="padding:10px; border:1px solid #ddd;">Precio Unitario</th>
                    <th style="padding:10px; border:1px solid #ddd;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compra->detalles as $detalle)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $detalle->producto->nombre }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $detalle->cantidad }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">Bs {{ number_format($detalle->preciounitario,2) }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">Bs {{ number_format($detalle->subtotal,2) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold;">
                    <td colspan="3" style="padding:10px; border:1px solid #ddd; text-align:right;">Total:</td>
                    <td style="padding:10px; border:1px solid #ddd;">Bs {{ number_format($compra->total,2) }}</td>
                </tr>
            </tbody>
        </table>
    @endif

</div>
@endsection
