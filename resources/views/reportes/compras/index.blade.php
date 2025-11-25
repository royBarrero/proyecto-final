@extends('plantillas.inicio')
@section('h1', 'Reporte de Compras')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_reportes'))
        <div class="alert alert-danger">No tienes permisos para ver reportes.</div>
        @php abort(403); @endphp
    @endif

    <h2>Reporte de Compras a Proveedores</h2>
    <x-alerta />
    
    <form method="GET" action="{{ route('reporte.compras') }}" class="form-filtros">
        <div class="form-row">
            <div class="form-group">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                       value="{{ request('fecha_inicio') }}">
            </div>
            
            <div class="form-group">
                <label for="fecha_fin">Fecha Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" 
                       value="{{ request('fecha_fin') }}">
            </div>
            
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select name="proveedor" id="proveedor" class="form-control">
                    <option value="">Todos</option>
                    @foreach($proveedores ?? [] as $prov)
                        <option value="{{ $prov->id }}" {{ request('proveedor') == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn-editar">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="resultados-reporte">
        <h3>Resultados</h3>
        <p><strong>Total de Compras:</strong> {{ $compras->count() }}</p>
        <p><strong>Monto Total:</strong> Bs {{ number_format($total ?? 0, 2) }}</p>
    </div>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('exportar_reportes_pdf'))
            <a href="{{ route('reporte.compras.pdf', request()->query()) }}" class="btn-editar" target="_blank">
                Exportar PDF
            </a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
