@extends('plantillas.inicio')
@section('h1', 'Gestión de Compras')

@section('contenido')
<div class="container">
    <h2>Lista de Compras a Proveedores</h2>
    <x-alerta />
    
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total (Bs)</th>
                <th>Estado</th>
                @if(auth()->user()->tieneAlgunPermiso(['ver_detalle_compras', 'editar_compras', 'eliminar_compras']))
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($compras ?? [] as $compra)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Fecha">{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                <td data-label="Proveedor">{{ $compra->proveedor->nombre ?? 'N/A' }}</td>
                <td data-label="Total">Bs {{ number_format($compra->total, 2) }}</td>
                <td data-label="Estado">
                    @if($compra->estado == 1)
                        <span class="badge badge-success">Pagado</span>
                    @else
                        <span class="badge badge-warning">Pendiente</span>
                    @endif
                </td>
                
                @if(auth()->user()->tieneAlgunPermiso(['ver_detalle_compras', 'editar_compras', 'eliminar_compras']))
                <td data-label="Acciones">
                    <div class="div-botones">
                        @if(auth()->user()->tienePermiso('ver_detalle_compras'))
                            <a href="{{ route('compras.show', $compra->id) }}" class="btn-editar">Ver</a>
                        @endif
                        
                        @if(auth()->user()->tienePermiso('editar_compras'))
                            <a href="{{ route('compras.edit', $compra->id) }}" class="btn-editar">Editar</a>
                        @endif
                        
                        @if(auth()->user()->tienePermiso('eliminar_compras'))
                            <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar compra #{{ $compra->id }}?')">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('crear_compras'))
            <a href="{{ route('compras.create') }}" class="btn-editar">Nueva Compra</a>
        @endif
        
        @if(auth()->user()->tienePermiso('generar_reporte_compras'))
            <a href="{{ route('reporte.compras') }}" class="btn btn-secondary">Ver Reportes</a>
        @endif
        
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
