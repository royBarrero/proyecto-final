@extends('plantillas.inicio')
@section('h1', 'Gestión de Ventas')

@section('contenido')
<div class="container">
    <h2>Lista de Ventas</h2>
    <x-alerta />
    
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total (Bs)</th>
                <th>Estado</th>
                @if(auth()->user()->tieneAlgunPermiso(['ver_ventas', 'editar_ventas']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($ventas ?? [] as $venta)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Fecha">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                <td data-label="Cliente">{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                <td data-label="Total">Bs {{ number_format($venta->total, 2) }}</td>
                <td data-label="Estado">
                    @if($venta->estado == 1)
                        <span class="badge badge-success">Completada</span>
                    @else
                        <span class="badge badge-warning">Pendiente</span>
                    @endif
                </td>
                
                @if(auth()->user()->tieneAlgunPermiso(['ver_ventas', 'editar_ventas']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        @if(auth()->user()->tienePermiso('ver_ventas'))
                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn-editar">Ver</a>
                        @endif
                        
                        @if(auth()->user()->tienePermiso('editar_ventas'))
                            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn-editar">Editar</a>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('crear_ventas'))
            <a href="{{ route('ventas.create') }}" class="btn-editar">Nueva Venta</a>
        @endif
        
        @if(auth()->user()->tienePermiso('ver_reportes'))
            <a href="{{ route('reportes.ventas.index') }}" class="btn btn-secondary">Ver Reportes</a>
        @endif
        
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
