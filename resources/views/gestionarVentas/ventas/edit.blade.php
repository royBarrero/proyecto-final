@extends('plantillas.inicio')
@section('h1','Editar Venta')

@section('contenido')
<style>
    .venta-container {
        max-width: 1200px;
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

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #555;
        font-size: 14px;
    }

    .form-group select,
    .form-group input {
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

    .producto-inputs {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    @media (max-width: 768px) {
        .producto-inputs {
            grid-template-columns: 1fr;
        }
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
        justify-content: center;
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

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 8px 16px;
        font-size: 13px;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
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
        background: white;
    }

    .styled-table tbody tr:hover {
        background: #f8f9fa;
    }

    .styled-table tbody tr:last-child {
        border-bottom: none;
    }

    .styled-table input {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .total-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        border-radius: 8px;
        color: white;
        text-align: right;
        margin: 20px 0;
    }

    .total-section label {
        font-size: 18px;
        font-weight: 600;
        margin-right: 15px;
    }

    .total-section input {
        font-size: 24px;
        font-weight: 700;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        text-align: right;
        width: 200px;
        background: white;
        color: #667eea;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    @media (max-width: 576px) {
        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .total-section input {
            width: 100%;
        }
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
</style>

<div class="venta-container">
    {{-- Validar permiso --}}
    @if(!auth()->user()->tienePermiso('editar_ventas'))
        <div class="alert alert-danger">
            <strong>⛔ Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
    <form id="ventaForm" action="{{ route('ventas.update',$venta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Sección: Información de la Venta -->
        <div class="card">
            <div class="card-header">
                <h3>📝 Editar Información de la Venta 
                    <span class="info-badge">ID: #{{ $venta->id }}</span>
                </h3>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="id_cliente">👤 Cliente *</label>
                    <select name="id_cliente" id="id_cliente" required>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" 
                                {{ (isset($venta->idcliente) && $venta->idcliente == $c->id) || 
                                   (isset($venta->id_cliente) && $venta->id_cliente == $c->id) ? 'selected' : '' }}>
                                {{ $c->nombre ?? $c->idusuarios }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_vendedor">💼 Vendedor *</label>
                    <select name="id_vendedor" id="id_vendedor" required>
                        @foreach($vendedores as $v)
                            <option value="{{ $v->id }}" 
                                {{ (isset($venta->idvendedor) && $venta->idvendedor == $v->id) || 
                                   (isset($venta->id_vendedor) && $venta->id_vendedor == $v->id) ? 'selected' : '' }}>
                                {{ $v->nombre ?? $v->idusuarios }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">💳 Método de Pago *</label>
                    <select name="metodo_pago" id="metodo_pago" required>
                        @foreach($metodos as $m)
                            <option value="{{ $m->id }}" 
                                {{ (isset($venta->metodopago) && $venta->metodopago == $m->id) || 
                                   (isset($venta->metodo_pago) && $venta->metodo_pago == $m->id) ? 'selected' : '' }}>
                                {{ $m->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Sección: Gestionar Productos -->
        <div class="card">
            <div class="card-header">
                <h3>🛒 Gestionar Productos</h3>
            </div>

            <div class="producto-section">
                <div class="producto-inputs">
                    <div class="form-group">
                        <label for="id_producto">ID Producto</label>
                        <input type="number" id="id_producto" placeholder="Ej: 1" min="1">
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" placeholder="Ej: 5" min="1">
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio Unit.</label>
                        <input type="number" id="precio" placeholder="Ej: 50.00" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label style="opacity: 0;">Acción</label>
                        <button type="button" id="agregarProducto" class="btn btn-primary">
                            ➕ Agregar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div style="overflow-x: auto;">
                <table id="tablaProductos" class="styled-table">
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th style="width: 120px;">Cantidad</th>
                            <th style="width: 120px;">Precio Unit.</th>
                            <th style="width: 120px;">Subtotal</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Sección: Total -->
        <div class="total-section">
            <label for="total">💰 TOTAL A PAGAR:</label>
            <input type="number" id="total" name="total" step="0.01" readonly>
        </div>

        <input type="hidden" name="detalles" id="detalles">

        <!-- Acciones del Formulario -->
        <div class="form-actions">
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                ← Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                ✓ Actualizar Venta
            </button>
        </div>
    </form>
</div>

<script>
    let productos = {!! json_encode($venta->detalles ?? []) !!};

    function actualizarTabla() {
        const tbody = document.querySelector('#tablaProductos tbody');
        tbody.innerHTML = '';
        let total = 0;

        if (productos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                        <p>⚠️ No hay productos en esta venta. Agrega al menos uno.</p>
                    </td>
                </tr>
            `;
        } else {
            productos.forEach((p, i) => {
                const cantidad = p.cantidad ?? 0;
                const precio = p.precio ?? p.preciounitario ?? 0;
                const idProducto = p.idproducto ?? p.id_producto ?? 0;
                
                const subtotal = cantidad * precio;
                total += subtotal;
                
                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td><strong>#${idProducto}</strong></td>
                        <td><input type="number" value="${cantidad}" min="1" onchange="editarCantidad(${i}, this.value)"></td>
                        <td><input type="number" value="${precio}" step="0.01" min="0" onchange="editarPrecio(${i}, this.value)"></td>
                        <td><strong>Bs ${subtotal.toFixed(2)}</strong></td>
                        <td><button type="button" class="btn btn-danger" onclick="eliminarProducto(${i})">🗑️ Eliminar</button></td>
                    </tr>
                `);
            });
        }

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('detalles').value = JSON.stringify(productos);
    }

    function agregarProducto() {
        const id = parseInt(document.getElementById('id_producto').value);
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const precio = parseFloat(document.getElementById('precio').value);

        if (!id || isNaN(id)) {
            return alert('⚠️ Por favor ingresa un ID de producto válido');
        }

        if (isNaN(cantidad) || cantidad <= 0) {
            return alert('⚠️ Por favor ingresa una cantidad válida');
        }

        if (isNaN(precio) || precio <= 0) {
            return alert('⚠️ Por favor ingresa un precio válido');
        }

        const existente = productos.find(p => (p.idproducto ?? p.id_producto) === id);
        if (existente) {
            existente.cantidad = (existente.cantidad ?? 0) + cantidad;
            existente.precio = precio;
        } else {
            productos.push({
                idproducto: id,
                cantidad,
                precio
            });
        }

        document.getElementById('id_producto').value = '';
        document.getElementById('cantidad').value = '';
        document.getElementById('precio').value = '';
        document.getElementById('id_producto').focus();

        actualizarTabla();
    }

    function eliminarProducto(i) {
        if (confirm('¿Estás seguro de eliminar este producto de la venta?')) {
            productos.splice(i, 1);
            actualizarTabla();
        }
    }

    function editarCantidad(i, val) {
        const cantidad = parseInt(val);
        if (cantidad > 0) {
            productos[i].cantidad = cantidad;
            actualizarTabla();
        } else {
            alert('⚠️ La cantidad debe ser mayor a 0');
            actualizarTabla();
        }
    }

    function editarPrecio(i, val) {
        const precio = parseFloat(val);
        if (precio > 0) {
            productos[i].precio = precio;
            actualizarTabla();
        } else {
            alert('⚠️ El precio debe ser mayor a 0');
            actualizarTabla();
        }
    }

    document.getElementById('agregarProducto').addEventListener('click', agregarProducto);

    ['id_producto', 'cantidad', 'precio'].forEach(id => {
        document.getElementById(id).addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                agregarProducto();
            }
        });
    });

    document.getElementById('ventaForm').addEventListener('submit', function(e) {
        if (productos.length === 0) {
            e.preventDefault();
            alert('⚠️ Debes tener al menos un producto en la venta');
            return false;
        }
    });

    actualizarTabla();
</script>

@endsection
