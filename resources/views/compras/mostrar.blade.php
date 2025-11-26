@extends('plantillas.inicio')
@section('h1', 'Compras registradas')

@section('contenido')
<style>
    .compras-container {
        max-width: 1400px;
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
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
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
        width: auto; /* IMPORTANTE: forzar ancho automático */
    }

    .btn-primary {
        background: #ef8504;
        color: white;
    }

    .btn-primary:hover {
        background: #d67604;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(239, 133, 4, 0.3);
    }

    .btn-excel {
        background: #217346;
        color: white;
    }

    .btn-excel:hover {
        background: #1a5c37;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(33, 115, 70, 0.3);
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .table-container {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        min-width: 800px;
    }

    .styled-table thead tr {
        background: #ef8504;
        color: white;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        white-space: nowrap;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .btn-ver {
        background: #ef8504;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        display: inline-block;
        white-space: nowrap;
    }

    .btn-ver:hover {
        background: #d67604;
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        white-space: nowrap;
    }

    .btn-eliminar:hover {
        background: #c82333;
    }

    .div-botones {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .badge-total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        margin-top: 8px;
    }

    .badge-estado {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-completado {
        background: #d4edda;
        color: #155724;
    }

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .footer-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            justify-content: stretch;
        }

        .header-actions .btn {
            flex: 1;
            min-width: 0;
        }
    }

    @media (max-width: 768px) {
        .header-actions {
            flex-direction: column;
            gap: 8px;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .table-container {
            padding: 15px;
        }

        .styled-table {
            font-size: 12px;
        }

        .div-botones {
            flex-direction: column;
            gap: 5px;
        }

        .btn-ver,
        .btn-eliminar {
            width: 100%;
            text-align: center;
            justify-content: center;
            display: flex;
        }

        .footer-actions {
            justify-content: center;
        }

        .footer-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .compras-container {
            padding: 10px;
        }

        .header-section {
            padding: 15px;
        }

        .header-section h2 {
            font-size: 20px;
        }

        .table-container {
            padding: 10px;
        }

        .styled-table {
            font-size: 11px;
        }

        .styled-table th,
        .styled-table td {
            padding: 8px 10px;
        }
    }
</style>

<div class="compras-container">
    <!-- Header -->
    <div class="header-section">
        <div>
            <h2>📦 Compras Registradas</h2>
            <span class="badge-total">Total: {{ count($compras) }} compras</span>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('compras.create') }}" class="btn btn-primary">
                ➕ Nueva Compra
            </a>
            <a href="{{ route('compras.exportar.excel') }}" class="btn btn-excel">
                📊 Exportar Excel
            </a>
            <a href="{{ route('compras.exportar.pdf') }}" class="btn btn-pdf" target="_blank">
                📄 Exportar PDF
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Tabla -->
    <div class="table-container">
        @if($compras->isEmpty())
            <div style="text-align: center; padding: 40px; color: #999;">
                <p style="font-size: 16px;">📭 No hay compras registradas</p>
                <a href="{{ route('compras.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                    ➕ Registrar primera compra
                </a>
            </div>
        @else
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td><strong>#{{ $compra->id }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td><strong>Bs {{ number_format($compra->total, 2) }}</strong></td>
                            <td>
                                <span class="badge-estado {{ $compra->estado == 'Completado' ? 'badge-completado' : 'badge-pendiente' }}">
                                    {{ $compra->estado }}
                                </span>
                            </td>
                            <td>
                                <div class="div-botones">
                                    <a href="{{ route('compras.show', $compra->id) }}" class="btn-ver">
                                        Ver
                                    </a>
                                    <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-eliminar" 
                                            onclick="return confirm('¿Eliminar compra ID {{ $compra->id }}?\nProveedor: {{ $compra->proveedor->nombre }}\nTotal: Bs {{ number_format($compra->total, 2) }}')">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Footer -->
    <div style="margin-top: 25px; display: flex; justify-content: flex-end;">
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-secondary">
            ← Volver al inicio
        </a>
    </div>
</div>
@endsection