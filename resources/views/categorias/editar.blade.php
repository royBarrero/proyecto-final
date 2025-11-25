@extends('plantillas.inicio')
@section('h1', 'Editar Categoría')

@section('contenido')
<div class="container">
    @if(!auth()->user()->tienePermiso('editar_categorias'))
        <div class="alert alert-danger">No tienes permisos para editar categorías.</div>
        @php abort(403); @endphp
    @endif

    <h2>Editar Categoría: {{ $categoria->nombre }}</h2>
    <x-alerta />
    
    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" class="form-style">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nombre">Nombre <span class="required">*</span></label>
            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                   value="{{ old('nombre', $categoria->nombre) }}" required maxlength="100">
            @error('nombre')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                      rows="4">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            @error('descripcion')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="div-botones2">
            <button type="submit" class="btn-editar">Actualizar</button>
            @if(auth()->user()->tienePermiso('eliminar_categorias'))
                <button type="button" class="btn-eliminar" 
                        onclick="if(confirm('¿Eliminar {{ $categoria->nombre }}?')) { document.getElementById('form-eliminar').submit(); }">
                    Eliminar
                </button>
            @endif
            <a href="{{ route('categorias.index') }}" class="btn btn-cerrar">Cancelar</a>
        </div>
    </form>

    @if(auth()->user()->tienePermiso('eliminar_categorias'))
        <form id="form-eliminar" action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>
@endsection
