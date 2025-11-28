<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Productos Aves</title>
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
            font-size: 11px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
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
        <h1>Lista de Productos Aves Ornamentales</h1>
        <p style="margin: 5px 0; font-size: 11px;">Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th style="text-align: right;">Precio</th>
                <th>Categoría</th>
                <th>Detalle Ave</th>
                <th style="text-align: center;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($aves as $ave)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $ave->nombre }}</td>
                <td style="text-align: right;">Bs {{ number_format($ave->precio, 2) }}</td>
                <td>{{ $ave->categoria->nombre ?? '-' }}</td>
                <td>{{ $ave->detalleAve->descripcion ?? '-' }}</td>
                <td style="text-align: center;">{{ $ave->cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión HuAviar - © {{ date('Y') }}</p>
        <p>Total de productos: {{ count($aves) }}</p>
    </div>
</body>
</html>