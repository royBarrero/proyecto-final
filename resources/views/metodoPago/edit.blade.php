@extends('plantillas.inicio')
@section('h1', 'Editar Método de Pago')

@section('contenido')
<style>
    .metodo-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 30px;
    }

    .card-header {
        border-bottom: 2px solid #ef8504;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .card-header h3 {
        color: #333;
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .info-badge {
        display: inline-block;
        background: #e3f2fd;
        color: #1976d2;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
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
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ef8504;
        box-shadow: 0 0 0 3px rgba(239, 133, 4, 0.1);
    }

    .form-group .error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
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
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
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

    @media (max-width: 576px) {
        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 80%;
            justify-content: center;
        }
    }
</style>

<div class="metodo-container">
    <div class="card">
        <div class="card-header">
            <h3>📝 Editar Método de Pago
                <span class="info-badge">ID: #{{ $metodo->id }}</span>
            </h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>⚠️ Error:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('metodopagos.update', $metodo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="descripcion">Descripción del Método de Pago *</label>
                <input 
                    type="text" 
                    id="descripcion" 
                    name="descripcion" 
                    value="{{ old('descripcion', $metodo->descripcion) }}"
                    placeholder="Ej: Efectivo, Tarjeta de Crédito, Transferencia Bancaria..."
                    required
                    maxlength="100"
                    autofocus>
                @error('descripcion')
                    <span class="error">{{ $message }}</span>
                @enderror
                <small style="color: #999; display: block; margin-top: 5px;">
                    Máximo 100 caracteres
                </small>
            </div>

            <div class="form-actions">
                <a href="{{ route('metodopagos.index') }}" class="btn btn-secondary">
                    ← Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    ✓ Actualizar Método
                </button>
            </div>
        </form>
    </div>
</div>
@endsection