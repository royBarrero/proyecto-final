@extends('plantillas.inicio')

@section('h1', 'Historial de Ventas')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_historial_ventas'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="container">

    <h2>Filtrar historial de ventas</h2>
    <form action="{{ route('reportes.historial.index') }}" method="GET" style="margin-bottom:20px;">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <div>
                <label>Fecha desde:</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
            </div>
            <div>
                <label>Fecha hasta:</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
            </div>
            <div>
                <label>Método de pago:</label>
                <select name="metodo_pago">
                    <option value="">Todos</option>
                    @foreach($metodos as $metodo)
                        <option value="{{ $metodo->id }}" @if(request('metodo_pago')==$metodo->id) selected @endif>
                            {{ $metodo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" style="padding:5px 15px; background:#ef8504; color:white; border:none; border-radius:5px;">
                    Filtrar
                </button>
            </div>
        </div>
    </form>

    <h3>Ventas</h3>
    @if($ventas->isEmpty())
        <p>No hay ventas registradas para los filtros seleccionados.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:#ef8504; color:white;">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Total</th>
                    <th>Método(s) de pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr style="border-bottom:1px solid #ddd;">
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

        <div style="margin-top:20px;">
            <a href="{{ route('reportes.historial.generar', request()->query()) }}" 
               style="padding:10px 20px; background:#ef8504; color:white; border-radius:5px; display:inline-block;">
               Exportar a PDF
            </a>
        </div>
    @endif
</div>
@endsection
