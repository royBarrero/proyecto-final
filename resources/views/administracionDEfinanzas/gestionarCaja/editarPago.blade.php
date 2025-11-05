@extends('plantillas.inicio')
@section('h1','Editar Movimiento')

@section('contenido')

<div class="form-box">
<form action="{{ route('pagos.update', $pago->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Tipo</label>
    <select name="tipo">
        <option value="ingreso" {{ $pago->tipo == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
        <option value="egreso" {{ $pago->tipo == 'egreso' ? 'selected' : '' }}>Egreso</option>
    </select>

    <label>Monto</label>
    <input type="number" name="monto" value="{{ $pago->monto }}" required>

    <label>Descripción</label>
    <input type="text" name="descripcion" value="{{ $pago->descripcion }}">

    <label>Método de Pago</label>
    <select name="idmetodopagos">
        @foreach($metodos as $m)
            <option value="{{ $m->id }}" {{ $m->id == $pago->idmetodopagos ? 'selected' : '' }}>
                {{ $m->descripcion }}
            </option>
        @endforeach
    </select>

    <button class="btn">Guardar Cambios</button>
</form>
</div>

@endsection
