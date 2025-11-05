<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:5px; text-align:left; }
        th { background-color:#ef8504; color:#fff; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Métodos de pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                <td>{{ $venta->vendedor->nombre ?? 'N/A' }}</td>
                <td>Bs {{ number_format($venta->total,2) }}</td>
                <td>
                    @foreach($venta->pagos as $pago)
                        {{ $pago->metodoPago->descripcion ?? 'N/A' }}: Bs {{ number_format($pago->monto,2) }}<br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
