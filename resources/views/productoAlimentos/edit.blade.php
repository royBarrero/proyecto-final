@extends('plantillas.inicio')
@section('h1', 'Editar Producto Alimento')

@section('contenido')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 20px;
    }

    .card-header {
        border-bottom: 2px solid #ef8504;
        padding-bottom: 15px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-header h3 {
        color: #333;
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        background: #e9ecef;
        color: #495057;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #555;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ef8504;
        box-shadow: 0 0 0 3px rgba(239, 133, 4, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert-danger ul {
        margin: 10px 0 0 20px;
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="form-container">
    @if(!auth()->user()->tienePermiso('editar_productos'))
        <div class="alert alert-danger">
            <strong>⛔ Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>⚠️ Errores en el formulario:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>🍖 Editar Producto Alimento</h3>
            <span class="badge">ID: {{ $alimento->id }}</span>
        </div>

        <form action="{{ route('productoalimentos.update', $alimento->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre del Producto *</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    value="{{ old('nombre', $alimento->nombre) }}"
                    placeholder="Ej: Alpiste Premium, Maíz Entero, etc."
                    required>
            </div>

            <div class="form-group">
                <label for="precio">Precio (Bs) *</label>
                <input 
                    type="number" 
                    id="precio" 
                    name="precio" 
                    value="{{ old('precio', $alimento->precio) }}"
                    step="0.01" 
                    min="0"
                    placeholder="0.00"
                    required>
            </div>

            <div class="form-actions">
                <a href="{{ route('productos.index', ['tab' => 'alimentos']) }}" class="btn btn-secondary">
                    ← Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    ✓ Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection