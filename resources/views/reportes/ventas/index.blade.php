@extends('plantillas.inicio')
@section('h1', 'Reporte de Ventas')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_reportes'))
        <div class="alert alert-danger">No tienes permisos para ver reportes.</div>
        @php abort(403); @endphp
    @endif

    <h2>Reporte de Ventas del Día</h2>
    <x-alerta />
    
    <form method="GET" action="{{ route('reportes.ventas.index') }}" class="form-filtros">
        <div class="form-row">
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" 
                       value="{{ request('fecha', date('Y-m-d')) }}">
            </div>
            
            <div class="form-group">
                <label for="vendedor">Vendedor</label>
                <select name="vendedor" id="vendedor" class="form-control">
                    <option value="">Todos</option>
                    @foreach($vendedores ?? [] as $vend)
                        <option value="{{ $vend->id }}" {{ request('vendedor') == $vend->id ? 'selected' : '' }}>
                            {{ $vend->nombre }}
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
        <h3>Resultados del {{ request('fecha', date('d/m/Y')) }}</h3>
        <p><strong>Total de Ventas:</strong> {{ $ventas->count() }}</p>
        <p><strong>Monto Total:</strong> Bs {{ number_format($total ?? 0, 2) }}</p>
    </div>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('exportar_reportes_pdf'))
            <a href="{{ route('reportes.ventas.pdf', request()->query()) }}" class="btn-editar" target="_blank">
                Exportar PDF
            </a>
        @endif
        
        @if(auth()->user()->tienePermiso('ver_historial_ventas'))
            <a href="{{ route('reportes.ventas.historial') }}" class="btn btn-secondary">Ver Historial</a>
        @endif
        
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
