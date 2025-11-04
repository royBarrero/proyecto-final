@extends('plantillas.inicio')
@section('h1','Caja')

@section('contenido')
<div class="container">
    <x-alerta />

    @if($caja)
        <h2>Caja Abierta</h2>
        <p><strong>Monto Inicial:</strong> {{ $caja->monto_inicial }}</p>
        <p><strong>Fecha Apertura:</strong> {{ $caja->fecha_apertura }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($caja->estado) }}</p>

        <div class="div-botones2">
            <a href="{{ route('caja.pagos.form', $caja->id) }}" class="btn-editar">Registrar Pago</a>
            <a href="{{ route('caja.movimientos', $caja->id) }}" class="btn">Ver Movimientos</a>

            <form action="{{ route('caja.cerrar', $caja->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn">Cerrar Caja</button>
            </form>
        </div>

    @else
        <h2>No hay caja abierta</h2>
        <a href="{{ route('caja.abrir.form') }}" class="btn">Abrir Caja</a>
    @endif
</div>
@endsection
