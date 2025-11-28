@extends('plantillas.inicio')
@section('h1', 'Gestión de Productos')

@section('contenido')
<style>
    .productos-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .header-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-section h2 {
        margin: 0 0 20px 0;
        color: #333;
        font-size: 24px;
    }

    /* Tabs */
    .tabs {
        display: flex;
        gap: 10px;
        border-bottom: 2px solid #eee;
        margin-bottom: 25px;
    }

    .tab {
        padding: 12px 30px;
        background: #f8f9fa;
        border: none;
        border-radius: 8px 8px 0 0;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        color: #666;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab:hover {
        background: #e9ecef;
        color: #333;
    }

    .tab.active {
        background: #ef8504;
        color: white;
        border-bottom: 2px solid #ef8504;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Header de cada tab */
    .tab-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .tab-header h3 {
        margin: 0;
        color: #333;
        font-size: 20px;
    }

    .tab-actions {
        display: flex;
        gap: 10px;
        align-items: center;
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
        white-space: nowrap;
    }

    .btn-primary {
        background: #ef8504;
        color: white;
    }

    .btn-primary:hover {
        background: #d67604;
        transform: translateY(-2px);
    }

    .btn-excel {
        background: #217346;
        color: white;
    }

    .btn-excel:hover {
        background: #1a5c37;
        transform: translateY(-2px);
    }

    .btn-pdf {
        background: #dc3545;
        color: white;
    }

    .btn-pdf:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    /* Tabla */
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .styled-table thead tr {
        background: #ef8504;
        color: white;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .styled-table tbody tr:last-child {
        border-bottom: none;
    }

    .div-botones {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-editar, .btn-eliminar {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-editar {
        background: #28a745;
        color: white;
    }

    .btn-editar:hover {
        background: #218838;
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
    }

    .btn-eliminar:hover {
        background: #c82333;
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

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state svg {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    @media (max-width: 768px) {
        .tab-header {
            flex-direction: column;
            align-items: stretch;
        }

        .tab-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .tabs {
            flex-direction: column;
        }

        .tab {
            border-radius: 8px;
        }

        .styled-table {
            font-size: 12px;
        }

        .styled-table th,
        .styled-table td {
            padding: 8px 10px;
        }
    }
</style>

<div class="productos-container">
    @if(!auth()->user()->tienePermiso('ver_productos'))
        <div class="alert alert-danger">
            <strong>⛔ Acceso Denegado:</strong> No tienes permisos para acceder a esta sección.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif

    <div class="header-section">
        <h2>📦 Gestión de Productos</h2>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab {{ $tab == 'alimentos' ? 'active' : '' }}" onclick="switchTab('alimentos')">
                🍖 Alimentos
            </button>
            <button class="tab {{ $tab == 'aves' ? 'active' : '' }}" onclick="switchTab('aves')">
                🐔 Aves Ornamentales
            </button>
        </div>

        <x-alerta />

        <!-- Tab Alimentos -->
        <div id="tab-alimentos" class="tab-content {{ $tab == 'alimentos' ? 'active' : '' }}">
            <div class="tab-header">
                <h3>Lista de Alimentos</h3>
                <div class="tab-actions">
                    @if(auth()->user()->tienePermiso('crear_productos'))
                        <a href="{{ route('productoalimentos.create') }}" class="btn btn-primary">
                            ➕ Nuevo Alimento
                        </a>
                    @endif
                    <a href="{{ route('productos.alimentos.excel') }}" class="btn btn-excel">📊 Excel</a>
<a href="{{ route('productos.alimentos.pdf') }}" class="btn btn-pdf" target="_blank">📄 PDF</a>
                </div>
            </div>

            @if($alimentos->isEmpty())
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p>No hay productos de alimentos registrados</p>
                    @if(auth()->user()->tienePermiso('crear_productos'))
                        <a href="{{ route('productoalimentos.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                            ➕ Crear primer alimento
                        </a>
                    @endif
                </div>
            @else
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio (Bs)</th>
                            <th>Stock</th>
                            @if(auth()->user()->tieneAlgunPermiso(['editar_productos', 'eliminar_productos']))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alimentos as $alimento)
                        <tr>
                            <td>{{ $alimento->id }}</td>
                            <td>{{ $alimento->nombre }}</td>
                            <td>Bs {{ number_format($alimento->precio, 2) }}</td>
                            <td>{{ $alimento->stock ?? 0 }}</td>
                            @if(auth()->user()->tieneAlgunPermiso(['editar_productos', 'eliminar_productos']))
                            <td>
                                <div class="div-botones">
                                    @if(auth()->user()->tienePermiso('editar_productos'))
                                        <a href="{{ route('productoalimentos.edit', $alimento->id) }}" class="btn-editar">Editar</a>
                                    @endif
                                    @if(auth()->user()->tienePermiso('eliminar_productos'))
                                        <form action="{{ route('productoalimentos.destroy', $alimento->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar {{ $alimento->nombre }}?')">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Tab Aves -->
        <div id="tab-aves" class="tab-content {{ $tab == 'aves' ? 'active' : '' }}">
            <div class="tab-header">
                <h3>Lista de Aves Ornamentales</h3>
                <div class="tab-actions">
                    @if(auth()->user()->tienePermiso('crear_productos'))
                        <a href="{{ route('productoaves.create') }}" class="btn btn-primary">
                            ➕ Nueva Ave
                        </a>
                    @endif
                   <a href="{{ route('productos.aves.excel') }}" class="btn btn-excel">📊 Excel</a>
<a href="{{ route('productos.aves.pdf') }}" class="btn btn-pdf" target="_blank">📄 PDF</a>
                </div>
            </div>

            @if($aves->isEmpty())
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p>No hay productos de aves registrados</p>
                    @if(auth()->user()->tienePermiso('crear_productos'))
                        <a href="{{ route('productoaves.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                            ➕ Crear primera ave
                        </a>
                    @endif
                </div> 
            @else
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio (Bs)</th>
                            <th>Categoría</th>
                            <th>Detalle Ave</th>
                            <th>Cantidad</th>
                            @if(auth()->user()->tieneAlgunPermiso(['ver_productos', 'editar_productos', 'eliminar_productos']))
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aves as $ave)
                        <tr>
                            <td>{{ $ave->id }}</td>
                            <td>{{ $ave->nombre }}</td>
                            <td>Bs {{ number_format($ave->precio, 2) }}</td>
                            <td>{{ $ave->categoria->nombre ?? '-' }}</td>
                            <td>{{ $ave->detalleAve->descripcion ?? '-' }}</td>
                            <td>{{ $ave->cantidad }}</td>
                            @if(auth()->user()->tieneAlgunPermiso(['ver_productos', 'editar_productos', 'eliminar_productos']))
                            <td>
                                <div class="div-botones">
                                    @if(auth()->user()->tienePermiso('ver_productos'))
                                        <a href="{{ route('productoaves.show', $ave->id) }}" class="btn-editar">Ver</a>
                                    @endif
                                    @if(auth()->user()->tienePermiso('editar_productos'))
                                        <a href="{{ route('productoaves.edit', $ave->id) }}" class="btn-editar">Editar</a>
                                    @endif
                                    @if(auth()->user()->tienePermiso('eliminar_productos'))
                                        <form action="{{ route('productoaves.destroy', $ave->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar {{ $ave->nombre }}?')">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn btn-secondary">← Volver al Dashboard</a>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Actualizar URL sin recargar
    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.pushState({}, '', url);

    // Ocultar todos los tabs
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Mostrar tab seleccionado
    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.classList.add('active');
}
</script>
@endsection