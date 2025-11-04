@extends('plantillas.inicio')
@section('h1','Registrar Pago')

@section('contenido')
<div class="form-box">
    <form action="{{ route('caja.pagos.store') }}" method="POST">
        @csrf
        <input type="hidden" name="idcaja" value="{{ $caja->id }}">
        
        <div class="form-group">
            <label>Tipo de Pago</label>
            <select name="tipo" required>
                <option value="">Seleccione...</option>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
            </select>
        </div>

        <div class="form-group">
            <label>Monto</label>
            <input type="number" name="monto" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion">
        </div>

        <div class="form-group">
            <label>Método de Pago</label>
            <select name="idmetodopagos" required>
                <option value="">Seleccione...</option>
                @foreach($metodos as $m)
                    <option value="{{ $m->id }}">{{ $m->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Registrar Pago</button>
            <a href="{{ route('caja.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
