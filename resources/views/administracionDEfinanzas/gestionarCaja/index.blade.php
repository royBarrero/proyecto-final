@extends('plantillas.inicio')
@section('h1', 'Caja')

@section('contenido')
    <div class="container">
        <x-alerta />

        @if ($cajaA)
            <h2>Caja Abierta</h2>
            <p><strong>Monto Inicial:</strong> {{ $cajaA->monto_inicial }}</p>
            <p><strong>Fecha Apertura:</strong> {{ $cajaA->fecha_apertura }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($cajaA->estado) }}</p>

            <div class="div-botones2">
                <a href="{{ route('caja.pagos.form', $cajaA->id) }}" class="btn-editar">Registrar Pago</a>
                <a href="{{ route('caja.movimientos', $cajaA->id) }}" class="btn">Ver Movimientos</a>

                <form action="{{ route('caja.cerrar', $cajaA->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn">Cerrar Caja</button>
                </form>
            </div>
        @else
            <h2>No hay caja abierta</h2>
            <a href="{{ route('caja.abrir.form') }}" class="btn">Abrir Caja</a>
            @foreach ($cajaCerrada as $cajaC)
                <p><strong>Monto Inicial:</strong> {{ $cajaC->monto_inicial }}</p>
                <p><strong>Fecha Apertura:</strong> {{ $cajaC->fecha_apertura }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($cajaC->estado) }}</p>

                <div class="div-botones2">
                    <a href="{{ route('caja.movimientos', $cajaC->id) }}" class="btn">Ver Movimientos</a>
                </div>
                
            @endforeach
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn">Volver</a>
    </div>
@endsection
