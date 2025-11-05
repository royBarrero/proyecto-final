<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Compras</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top:10px; }
        th, td { border: 1px solid #000; padding:5px; text-align:left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Reporte de Compras</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ $compra->fecha }}</td>
                    <td>{{ $compra->proveedor->nombre }}</td>
                    <td>Bs {{ number_format($compra->total,2) }}</td>
                    <td>
                        <ul>
                            @foreach($compra->detalles as $detalle)
                                <li>{{ $detalle->producto->nombre ?? 'Sin producto' }}: {{ $detalle->cantidad }} x Bs {{ number_format($detalle->preciounitario,2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
