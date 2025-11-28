<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Productos Alimentos</title>
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
    <div class="header">
        <h1>🍖 Lista de Productos Alimentos</h1>
        <p style="margin: 5px 0; font-size: 11px;">Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th style="text-align: right;">Precio</th>
                <th style="text-align: center;">Stock</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($alimentos as $alimento)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $alimento->nombre }}</td>
                <td style="text-align: right;">Bs {{ number_format($alimento->precio, 2) }}</td>
                <td style="text-align: center;">{{ $alimento->stock ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión HuAviar - © {{ date('Y') }}</p>
        <p>Total de productos: {{ count($alimentos) }}</p>
    </div>
</body>
</html>