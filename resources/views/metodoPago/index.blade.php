@extends('plantillas.inicio')
@section('h1', 'Métodos de Pago')

@section('contenido')
<style>
    .metodos-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-section h2 {
        margin: 0;
        color: #333;
        font-size: 24px;
    }

    .btn {
        padding: 10px 20px;
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
        box-shadow: 0 4px 8px rgba(239, 133, 4, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    /* === FIX: BOTONES COMPACTOS Y SIN ANCHO COMPLETO === */
    .div-botones {
        display: flex;
        gap: 6px;
        justify-content: flex-start;
    }

    .div-botones a,
    .div-botones button {
        width: auto !important;
        display: inline-flex !important;
        white-space: nowrap;
    }

    .btn-editar {
        background: #007bff;
        color: white;
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 4px;
    }

    .btn-editar:hover {
        background: #0056b3;
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .btn-eliminar:hover {
        background: #c82333;
    }

    .table-container {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .styled-table thead tr {
        background: #ef8504;
        color: white;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 15px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .badge-total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        margin-top: 8px;
    }

    .footer-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
      .header-section .btn-primary {
    width: auto !important;
    display: inline-flex !important;
    white-space: nowrap;
}


        .btn {
            width: 70%;
            justify-content: center;
        }

        .div-botones {
            flex-direction: column;
        }

        .styled-table {
            font-size: 12px;
        }

        .styled-table th,
        .styled-table td {
            padding: 10px;
        }
    }
</style>


<div class="metodos-container">
    <!-- Header -->
    <div class="header-section">
        <div>
            <h2>💳 Métodos de Pago</h2>
            <span class="badge-total">Total: {{ count($metodos) }} métodos</span>
        </div>
        
        <a href="{{ route('metodopagos.create') }}" class="btn btn-primary">
            ➕ Nuevo Método
        </a>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabla -->
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($metodos as $index => $metodo)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $metodo->descripcion }}</td>
                    <td>
                        <div class="div-botones">
                            <a href="{{ route('metodopagos.edit', $metodo->id) }}" class="btn btn-editar">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('metodopagos.destroy', $metodo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-eliminar" 
                                    onclick="return confirm('¿Estás seguro de eliminar este método de pago?\n\n{{ $metodo->descripcion }}')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 40px; color: #999;">
                        <p style="font-size: 16px;">📭 No hay métodos de pago registrados</p>
                        <a href="{{ route('metodopagos.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                            ➕ Crear primer método
                        </a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer-actions">
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-secondary">
            ← Volver al inicio
        </a>
    </div>
</div>
@endsection