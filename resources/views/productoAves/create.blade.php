@extends('plantillas.inicio')
@section('h1', 'Nuevo Producto de Ave')

@section('contenido')
<div class="form-box">
    <form action="{{ route('productoaves.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nombre del Ave</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label>Precio (Bs)</label>
            <input type="number" name="precio" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <select name="idcategorias" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Detalle del Ave</label>
            <select name="iddetalleaves" required>
                <option value="">Seleccione un detalle</option>
                @foreach($detalles ?? [] as $detalle)
                    <option value="{{ $detalle->id }}">{{ $detalle->descripcion }} ({{ $detalle->edad }} días)</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Cantidad</label>
            <input type="number" name="cantidad" min="0" required>
        </div>
        
        <div class="form-group">
            <label>Foto (opcional)</label>
            <input type="file" name="fotos[]" accept="image/*" multiple>
        </div>

        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('productoaves.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
