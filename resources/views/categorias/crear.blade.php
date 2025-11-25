@extends('plantillas.inicio')
@section('h1', 'Nueva Categoría')

@section('contenido')
<div class="container">
    {{-- Validar permiso --}}
    @if(!auth()->user()->tienePermiso('crear_categorias'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para crear categorías.
        </div>
        @php
            abort(403, 'No tienes permisos para crear categorías');
        @endphp
    @endif

    <h2>Crear Nueva Categoría</h2>
    <x-alerta />
    
    <form action="{{ route('categorias.store') }}" method="POST" class="form-style">
        @csrf
        
        <div class="form-group">
            <label for="nombre">Nombre de la Categoría <span class="required">*</span></label>
            <input type="text" 
                   id="nombre" 
                   name="nombre" 
                   class="form-control @error('nombre') is-invalid @enderror" 
                   value="{{ old('nombre') }}" 
                   placeholder="Ej: Aves de Corral, Aves Ornamentales"
                   required
                   maxlength="100">
            @error('nombre')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" 
                      name="descripcion" 
                      class="form-control @error('descripcion') is-invalid @enderror" 
                      rows="4"
                      placeholder="Describe esta categoría...">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="div-botones2">
            <button type="submit" class="btn-editar">Guardar Categoría</button>
            <a href="{{ route('categorias.index') }}" class="btn-eliminar">Cancelar</a>
        </div>
    </form>
</div>
@endsection
