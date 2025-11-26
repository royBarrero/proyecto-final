@extends('plantillas.inicio')
@section('h1', 'Registrar Nueva Compra')

@section('contenido')
<style>
    .compra-container {
        max-width: 1000px;
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
    }

    .card-header h3 {
        color: #333;
        margin: 0;
        font-size: 20px;
        font-weight: 600;
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

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #ef8504;
        box-shadow: 0 0 0 3px rgba(239, 133, 4, 0.1);
    }

    .producto-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .producto-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 10px;
        margin-bottom: 10px;
        align-items: end;
    }

    .producto-row select,
    .producto-row input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
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

    .btn-primary {
        background: #ef8504;
        color: white;
    }

    .btn-primary:hover {
        background: #d67604;
        transform: translateY(-2px);
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

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 8px;
        font-size: 16px;
    }

    .btn-danger:hover {
        background: #c82333;
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

    .alert-danger ul {
        margin: 10px 0 0 20px;
    }

    @media (max-width: 768px) {
        .producto-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="compra-container">
    @if(!auth()->user()->tienePermiso('crear_compras'))
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

    <form action="{{ route('compras.store') }}" method="POST">
        @csrf

        <!-- Información del Proveedor -->
        <div class="card">
            <div class="card-header">
                <h3>📦 Información de la Compra</h3>
            </div>

            <div class="form-group">
                <label for="idproveedors">🏢 Proveedor *</label>
                <select name="idproveedors" id="idproveedors" required>
                    <option value="">Seleccione un proveedor...</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ old('idproveedors') == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Productos -->
        <div class="card">
            <div class="card-header">
                <h3>🛒 Productos a Comprar</h3>
            </div>

            <div class="producto-section">
                <div id="productosContainer">
                    <div class="producto-row">
                        <select name="productos[0][idproductoalimentos]" required>
                            <option value="">Seleccione un producto...</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="productos[0][cantidad]" placeholder="Cantidad" min="1" required>
                        <input type="number" name="productos[0][preciounitario]" placeholder="Precio unit." min="0" step="0.01" required>
                        <button type="button" class="btn btn-danger" onclick="eliminarProducto(this)" title="Eliminar">
                            🗑️
                        </button>
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary" onclick="agregarProducto()" style="margin-top: 15px;">
                    ➕ Agregar Producto
                </button>
            </div>
        </div>

        <!-- Acciones -->
        <div class="form-actions">
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                ← Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                ✓ Registrar Compra
            </button>
        </div>
    </form>
</div>

<script>
    let productoIndex = 1;

    function agregarProducto() {
        const container = document.getElementById('productosContainer');
        const newRow = document.createElement('div');
        newRow.classList.add('producto-row');
        newRow.innerHTML = `
            <select name="productos[${productoIndex}][idproductoalimentos]" required>
                <option value="">Seleccione un producto...</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
            <input type="number" name="productos[${productoIndex}][cantidad]" placeholder="Cantidad" min="1" required>
            <input type="number" name="productos[${productoIndex}][preciounitario]" placeholder="Precio unit." min="0" step="0.01" required>
            <button type="button" class="btn btn-danger" onclick="eliminarProducto(this)" title="Eliminar">
                🗑️
            </button>
        `;
        container.appendChild(newRow);
        productoIndex++;
    }

    function eliminarProducto(btn) {
        const container = document.getElementById('productosContainer');
        if (container.children.length > 1) {
            btn.parentElement.remove();
        } else {
            alert('⚠️ Debe haber al menos un producto en la compra.');
        }
    }
</script>
@endsection