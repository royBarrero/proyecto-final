@extends('plantillas.inicio')
@section('h1', 'Editar Producto de Ave')

@section('contenido')
<div class="form-box">
    <form action="{{ route('productoaves.update', $productoAve->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del Ave</label>
            <input type="text" name="nombre" value="{{ old('nombre', $productoAve->nombre) }}" required>
        </div>

        <div class="form-group">
            <label>Precio (Bs)</label>
            <input type="number" name="precio" step="0.01" min="0" value="{{ old('precio', $productoAve->precio) }}" required>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <select name="idcategorias" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $productoAve->idcategorias == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Detalle del Ave</label>
            <p>{{ $productoAve->detalleAve->edad }} días</p>
        </div>


        <div class="form-group">
            <label>Cantidad</label>
            <input type="number" name="cantidad" min="0" value="{{ old('cantidad', $productoAve->cantidad) }}" required>
        </div>

        <div class="form-group">
            <label>Foto (opcional)</label>
            <input type="file" name="fotos[]" accept="image/*" multiple>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('productoaves.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>
@endsection
