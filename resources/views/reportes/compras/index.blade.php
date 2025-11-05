@extends('plantillas.inicio')

@section('h1', 'Reporte de Compras')

@section('contenido')
<div class="container">

    <form action="{{ route('reporte.compras') }}" method="GET" class="mb-4">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
            <select name="proveedor_id" class="form-control">
                <option value="">Todos los proveedores</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id }}" {{ request('proveedor_id') == $prov->id ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('reporte.compras.pdf', request()->query()) }}" class="btn btn-danger">Exportar PDF</a>
        </div>
    </form>

    @if($compras->isEmpty())
        <p>No hay compras registradas con los filtros seleccionados.</p>
    @else
        <table class="table table-bordered">
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
    @endif

</div>
@endsection
