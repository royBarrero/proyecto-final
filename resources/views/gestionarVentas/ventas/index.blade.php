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
                @if(auth()->user()->tieneAlgunPermiso(['editar_ventas', 'eliminar_ventas']))

                    <th>Acciones</th>

                @endif
            </tr>
        </thead>
        <tbody>
        @php $i=0; @endphp
        @foreach($ventas ?? [] as $venta)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $venta->cliente ?? '-' }}</td>
                <td>{{ $venta->vendedor ?? '-' }}</td>
                <td>{{ $venta->metodo_pago ?? '-' }}</td>
                <td>{{ number_format($venta->total, 2) }}</td>
                {{--<td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>--}}
                <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                <td>
                    <div class="div-botones">
                        @if(auth()->user()->tienePermiso('editar_ventas'))
                            <a href="{{ route('ventas.edit',$venta->id) }}" class="btn-editar">Editar</a>
                        @endif
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
