@extends('plantillas.inicio')
@section('h1','Ventas')

@section('contenido')
<div class="container">
    <h2>Lista de Ventas</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @php $i=0; @endphp
        @foreach($ventas ?? [] as $venta)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $venta->cliente->nombre ?? '-' }}</td>
                <td>{{ $venta->vendedor->nombre ?? '-' }}</td>
                <td>{{ $venta->metodoPago->descripcion ?? '-' }}</td>
                <td>{{ number_format($venta->total, 2) }}</td>
                <td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="div-botones">
                        <a href="{{ route('ventas.edit',$venta->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('ventas.destroy',$venta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar esta venta?\nCliente: {{ $venta->cliente->idusuarios ?? '---' }}')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-botones2">
        
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
