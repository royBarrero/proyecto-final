<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Compras</title>
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
    <h1> Lista de Compras</h1>
    <p style="text-align: center;">Generado el {{ date('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
            <tr>
                <td>#{{ $compra->id }}</td>
                <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                <td>{{ $compra->proveedor->nombre }}</td>
                <td>Bs {{ number_format($compra->total, 2) }}</td>
                <td>{{ $compra->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión HuAviar - © {{ date('Y') }}</p>
    </div>
</body>
</html>