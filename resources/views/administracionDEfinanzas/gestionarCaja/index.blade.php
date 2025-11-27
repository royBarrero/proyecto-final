@extends('plantillas.inicio')
@section('h1', 'Gestión de Caja')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('ver_caja'))
        <div class="alert alert-danger">No tienes permisos para ver esta sección.</div>
        @php abort(403); @endphp
    @endif

    <h2>Estado de Caja</h2>
    <x-alerta />
    
    @if($cajaAbierta)
        <div class="info-caja">
            <p><strong>Estado:</strong> <span class="badge badge-success">Abierta</span></p>
            <p><strong>Monto Inicial:</strong> Bs {{ number_format($cajaAbierta->monto_inicial, 2) }}</p>
            <p><strong>Ingresos:</strong> Bs {{ number_format($cajaAbierta->ingresos ?? 0, 2) }}</p>
            <p><strong>Egresos:</strong> Bs {{ number_format($cajaAbierta->egresos ?? 0, 2) }}</p>
            <p><strong>Saldo Actual:</strong> Bs {{ number_format($cajaAbierta->saldo_actual, 2) }}</p>
        </div>

        <div class="div-botones2">
            @if(auth()->user()->tienePermiso('ver_movimientos_caja'))
                <a href="{{ route('caja.movimientos', $cajaAbierta->id) }}" class="btn-editar">Ver Movimientos</a>
            @endif
            
            @if(auth()->user()->tienePermiso('cerrar_caja'))
                <form action="{{ route('caja.cerrar', $cajaAbierta->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-eliminar" onclick="return confirm('¿Cerrar caja?')">Cerrar Caja</button>
                </form>
            @endif
        </div>
    @else
        <p>No hay caja abierta actualmente.</p>
        
        @if(auth()->user()->tienePermiso('abrir_caja'))
            <div class="div-botones2">
                <a href="{{ route('caja.abrir.form') }}" class="btn-editar">Abrir Caja</a>
            </div>
        @endif
    @endif
    
    <div class="div-botones2">
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
