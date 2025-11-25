@extends('plantillas.inicio')
@section('h1','Pagos')

@section('contenido')
<div class="container">
    <h2>Lista de Pagos</h2>
    <x-alerta />
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Pedido</th>
                <th>Método</th>
                @if(auth()->user()->tieneAlgunPermiso(['editar_pagos', 'eliminar_pagos']))

                    <th>Acciones</th>

                @endif
            </tr>
        </thead>
        <tbody>
        @php $i=0; @endphp
        @foreach($pagos ?? [] as $pago)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $pago->fecha }}</td>
                <td>{{ $pago->monto }}</td>
                <td>{{ $pago->estado == 1 ? 'Pagado' : 'Pendiente' }}</td>
                <td>{{ $pago->pedido->id ?? '-' }}</td>
                <td>{{ $pago->metodoPago->descripcion ?? '-' }}</td>
                <td>
                    <div class="div-botones">
                        @if(auth()->user()->tienePermiso('editar_pagos'))
                            <a href="{{ route('pagos.edit',$pago->id) }}" class="btn-editar">Editar</a>
                        @endif
                        <form action="{{ route('pagos.destroy',$pago->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este pago?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('crear_pagos'))
            <a href="{{ route('pagos.create') }}" class="btn-editar">Nuevo Pago</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
