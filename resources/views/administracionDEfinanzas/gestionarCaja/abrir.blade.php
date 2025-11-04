@extends('plantillas.inicio')
@section('h1','Abrir Caja')

@section('contenido')
<div class="form-box">
    <form action="{{ route('caja.abrir') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Monto Inicial</label>
            <input type="number" name="monto_inicial" step="0.01" required>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Abrir Caja</button>
            <a href="{{ route('caja.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
