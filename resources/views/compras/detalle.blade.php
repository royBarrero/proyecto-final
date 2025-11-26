@extends('plantillas.inicio')
@section('h1', 'Detalle de compra')

@section('contenido')
<style>
    .detalle-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .header-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-section h2 {
        margin: 0;
        color: #333;
        font-size: 24px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .btn-pdf {
        background: #dc3545;
        color: white;
    }

    .btn-pdf:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .info-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .info-card h3 {
        color: #333;
        font-size: 18px;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #ef8504;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #ef8504;
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .info-item .value {
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }

    .table-container {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .table-container h3 {
        color: #333;
        font-size: 18px;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #ef8504;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        min-width: 600px;
    }

    .styled-table thead tr {
        background: #ef8504;
        color: white;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .styled-table tfoot tr {
        background: #f8f9fa;
        font-weight: 700;
        font-size: 16px;
    }

    .styled-table tfoot td {
        padding: 15px;
        border-top: 2px solid #ef8504;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .badge-estado {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-completado {
        background: #d4edda;
        color: #155724;
    }

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: stretch;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .table-container {
            padding: 15px;
        }

        .styled-table {
            font-size: 12px;
        }

        .styled-table th,
        .styled-table td {
            padding: 8px 10px;
        }
    }

    @media (max-width: 480px) {
        .detalle-container {
            padding: 10px;
        }

        .header-section,
        .info-card,
        .table-container {
            padding: 15px;
        }
    }
</style>

<div class="detalle-container">
    @if(!auth()->user()->tienePermiso('ver_detalle_compras'))
        <div class="alert alert-danger">
            <strong>⛔ Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif

    <!-- Header -->
    <div class="header-section">
        <h2>📦 Detalle de Compra #{{ $compra->id }}</h2>
        
        <div class="header-actions">
            <a href="{{ route('compras.exportar.detalle.pdf', $compra->id) }}" class="btn btn-pdf" target="_blank">
                📄 Exportar PDF
            </a>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                ← Volver
            </a>
        </div>
    </div>

    <!-- Información de la compra -->
    <div class="info-card">
        <h3>📋 Información General</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>ID Compra</label>
                <div class="value">#{{ $compra->id }}</div>
            </div>
            <div class="info-item">
                <label>Fecha</label>
                <div class="value">{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <label>Proveedor</label>
                <div class="value">{{ $compra->proveedor->nombre }}</div>
            </div>
            <div class="info-item">
                <label>Estado</label>
                <div class="value">
                    <span class="badge-estado {{ $compra->estado == 'Completado' ? 'badge-completado' : 'badge-pendiente' }}">
                        {{ $compra->estado }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="table-container">
        <h3>📦 Productos Adquiridos</h3>

        @if($compra->detalles->isEmpty())
            <div class="empty-state">
                <p>📭 No hay productos en esta compra.</p>
            </div>
        @else
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: right;">Precio Unit.</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td style="text-align: center;">{{ $detalle->cantidad }}</td>
                            <td style="text-align: right;">Bs {{ number_format($detalle->preciounitario, 2) }}</td>
                            <td style="text-align: right;">Bs {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;">💰 TOTAL:</td>
                        <td style="text-align: right; color: #ef8504;">Bs {{ number_format($compra->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
@endsection