@extends('plantillas.inicio')
@section('h1', 'Movimientos de Caja')

@section('contenido')
    <div class="container">
        <x-alerta />

        <h2>Caja #{{ $caja->id }} - Estado: {{ ucfirst($caja->estado) }}</h2>
        <p><strong>Monto Inicial:</strong> {{ $caja->monto_inicial }}</p>
        <p><strong>Saldo Actual:</strong> {{ $saldo }}</p>

        <form method="GET" class="form-box" style="margin-bottom:20px;">
            <div class="form-group">
                <label>Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>
            <div class="form-group">
                <label>Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>
            <button type="submit" class="btn">Filtrar</button>
        </form>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Método</th>
                    <th>Fecha</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($pagos as $pago)
                    <tr>
                        <td data-label="ID">{{ $pago->id }}</td>
                        <td data-label="Tipo">{{ ucfirst($pago->tipo) }}</td>
                        <td data-label="Monto">{{ $pago->monto }}</td>
                        <td data-label="Descripción">{{ $pago->descripcion }}</td>
                        <td data-label="Método">{{ $pago->metodoPago->descripcion ?? '' }}</td>
                        <td data-label="Fecha">{{ $pago->fecha }}</td>
                        <td data-label="Acciones">
                            <div class="div-botones">
                                <a href="{{ route('pagos.edit', $pago->id) }}" class="btn-editar">{{__('Editar')}}</a>

                                <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar"
                                        onclick="return confirm('¿Eliminar este movimiento?\nTipo: {{ ucfirst($pago->tipo) }}\nMonto: {{ $pago->monto }} Bs')">
                                        {{__('Eliminar')}}
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('caja.index') }}" class="btn" style="margin-top:15px;">Volver</a>
    </div>
@endsection
