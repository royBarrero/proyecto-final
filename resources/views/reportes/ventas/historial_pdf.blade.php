<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Ventas</title>
    <style>
        body { font-family: sans-serif; font-size:12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:5px; text-align:left; }
        th { background-color: #ef8504; color:white; }
    </style>
</head>
<body>
    <h2>Historial de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Método de pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                <td>{{ $venta->vendedor->nombre ?? 'N/A' }}</td>
                <td>Bs {{ number_format($venta->total, 2) }}</td>
                <td>
                    @foreach($venta->pagos as $pago)
                        {{ $pago->metodoPago->descripcion ?? 'N/A' }}
                        @if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
