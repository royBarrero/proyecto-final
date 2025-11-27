@extends('plantillas.inicio')
@section('h1','Ventas')

@section('contenido')
<style>
    .ventas-container {
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

    .btn-primary {
        background: #ef8504;
        color: white;
    }

    .btn-primary:hover {
        background: #d67604;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(239, 133, 4, 0.3);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
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

    .btn-editar {
        background: #007bff;
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-editar:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-eliminar:hover {
        background: #c82333;
        transform: translateY(-1px);
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

    .styled-table th {
        font-weight: 600;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .styled-table tbody tr:last-child {
        border-bottom: none;
    }

    .div-botones {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .footer-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
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

    /* Responsive */
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

        .div-botones {
            flex-direction: column;
            gap: 5px;
        }

        .btn-editar,
        .btn-eliminar {
            width: 100%;
            text-align: center;
            justify-content: center;
            display: flex;
        }

        .footer-actions {
            justify-content: center;
        }
    }

    /* Tablets */
    @media (max-width: 1024px) and (min-width: 769px) {
        .styled-table {
            font-size: 13px;
        }

        .styled-table th,
        .styled-table td {
            padding: 10px 12px;
        }
    }

    /* Para pantallas muy pequeñas */
    @media (max-width: 480px) {
        .ventas-container {
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
            border-radius: 8px;
        }

        .styled-table {
            font-size: 11px;
        }

        .styled-table th,
        .styled-table td {
            padding: 6px 8px;
        }

        .btn {
            font-size: 13px;
            padding: 8px 16px;
        }

        .btn-editar,
        .btn-eliminar {
            font-size: 11px;
            padding: 5px 10px;
        }
    }
</style>

<div class="ventas-container">
    <!-- Header con acciones -->
    <div class="header-section">
        <div>
            <h2>📋 Lista de Ventas</h2>
            <span class="badge-total">Total: {{ count($ventas ?? []) }} ventas</span>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                ➕ Nueva Venta
            </a>
            <a href="{{ route('ventas.exportar.excel') }}" class="btn btn-excel">
                📊 Exportar Excel
            </a>
            <a href="{{ route('ventas.exportar.pdf') }}" class="btn btn-pdf" target="_blank">
                📄 Exportar PDF
            </a>
        </div>
    </div>

    <!-- Alertas -->
    <x-alerta />

    <!-- Tabla de ventas -->
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Método de Pago</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    @if(auth()->user()->tieneAlgunPermiso(['editar_ventas', 'eliminar_ventas']))
                        <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @php $i=0; @endphp
            @forelse($ventas ?? [] as $venta)
                <tr>
                    <td><strong>{{ ++$i }}</strong></td>
                    <td>{{ $venta->cliente ?? '-' }}</td>
                    <td>{{ $venta->vendedor ?? '-' }}</td>
                    <td>{{ $venta->metodo_pago ?? '-' }}</td>
                    <td><strong>Bs {{ number_format($venta->total, 2) }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                    @if(auth()->user()->tieneAlgunPermiso(['editar_ventas', 'eliminar_ventas']))
                    <td>
                        <div class="div-botones">
                            @if(auth()->user()->tienePermiso('editar_ventas'))
                                <a href="{{ route('ventas.edit',$venta->id) }}" class="btn btn-editar">
                                    ✏️ Editar
                                </a>
                            @endif

                            @if(auth()->user()->tienePermiso('eliminar_ventas'))
                            <form action="{{ route('ventas.destroy',$venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Eliminar esta venta?\nCliente: {{ $venta->cliente ?? '---' }}\nTotal: Bs {{ number_format($venta->total, 2) }}')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        <p style="font-size: 16px;">📭 No hay ventas registradas</p>
                        <a href="{{ route('ventas.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                            ➕ Crear primera venta
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Botón volver -->
    <div class="footer-actions">
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-secondary">
            ← Volver al inicio
        </a>
    </div>
</div>
@endsection