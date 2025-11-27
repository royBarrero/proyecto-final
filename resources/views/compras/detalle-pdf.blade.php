<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detalle de Compra #{{ $compra->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ef8504;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #ef8504;
            margin: 0 0 10px 0;
        }
        .info-section {
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item label {
            font-weight: bold;
            color: #555;
            display: block;
            font-size: 11px;
        }
        .info-item .value {
            font-size: 13px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #ef8504;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        tfoot tr {
            background: #f8f9fa;
            font-weight: bold;
            font-size: 14px;
        }
        tfoot td {
            padding: 12px;
            border-top: 2px solid #ef8504;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1> Detalle de Compra</h1>
        <p style="margin: 5px 0;">ID: #{{ $compra->id }}</p>
        <p style="margin: 5px 0; font-size: 11px;">Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h3 style="margin: 0 0 15px 0; color: #333;">Información General</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Fecha de Compra:</label>
                <div class="value">{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <label>Proveedor:</label>
                <div class="value">{{ $compra->proveedor->nombre }}</div>
            </div>
            <div class="info-item">
                <label>Estado:</label>
                <div class="value">{{ $compra->estado }}</div>
            </div>
            <div class="info-item">
                <label>Total:</label>
                <div class="value" style="color: #ef8504; font-weight: bold;">Bs {{ number_format($compra->total, 2) }}</div>
            </div>
        </div>
    </div>

    <h3 style="margin: 25px 0 10px 0; color: #333;">Productos Adquiridos</h3>
    
    <table>
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
                <td colspan="3" style="text-align: right;">TOTAL:</td>
                <td style="text-align: right; color: #ef8504;">Bs {{ number_format($compra->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Sistema de Gestión HuAviar - © {{ date('Y') }}</p>
    </div>
</body>
</html>