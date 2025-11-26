<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #ef8504;
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
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1> Lista de Ventas</h1>
    <p style="text-align: center;">Generado el {{ date('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($ventas as $venta)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $venta->cliente ?? '-' }}</td>
                <td>{{ $venta->vendedor ?? '-' }}</td>
                <td>{{ $venta->metodo_pago ?? '-' }}</td>
                <td>Bs {{ number_format($venta->total, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión HuAviar - © {{ date('Y') }}</p>
    </div>
</body>
</html>