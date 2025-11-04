@extends('plantillas.inicio')
@section('h1','Nueva Venta')

@section('contenido')
<div class="form-box">
    <form id="ventaForm" action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Cliente</label>
            <select name="id_cliente" required>
                <option value="">Seleccione...</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Enviar el ID del usuario logueado como vendedor automáticamente --}}
        <input type="hidden" name="id_vendedor" value="{{ Auth::user()->id }}">

        <div class="form-group">
            <label>Método de Pago</label>
            <select name="metodo_pago" required>
                <option value="">Seleccione...</option>
                @foreach($metodos as $m)
                    <option value="{{ $m->id }}">{{ $m->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <h3>Detalle de Productos</h3>

        <div style="display:flex; gap:10px;">
            <select id="producto_select" style="width:200px;">
                <option value="">Seleccione producto...</option>
                @foreach($productos as $p)
                    <option value="{{ $p->id }}" data-nombre="{{ $p->nombre }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
            <input type="number" id="cantidad" placeholder="Cantidad" style="width:120px;">
            <input type="number" id="precio" placeholder="Precio" step="0.01" style="width:120px;">
            <button type="button" id="agregarProducto" class="btn-editar">Agregar</button>
        </div>

        <table id="tablaProductos" class="styled-table" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="form-group">
            <label>Total</label>
            <input type="number" id="total" name="total" step="0.01" readonly>
        </div>

        <input type="hidden" name="detalles" id="detalles">

        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>

<script>
    let productos = [];

    function actualizarTabla() {
        const tbody = document.querySelector('#tablaProductos tbody');
        tbody.innerHTML = '';
        let total = 0;

        productos.forEach((p, i) => {
            const subtotal = p.cantidad * p.precio;
            total += subtotal;
            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${p.nombre}</td>
                    <td><input type="number" value="${p.cantidad}" min="1" onchange="editarCantidad(${i}, this.value)"></td>
                    <td><input type="number" value="${p.precio}" step="0.01" onchange="editarPrecio(${i}, this.value)"></td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn-eliminar" onclick="eliminarProducto(${i})">Eliminar</button></td>
                </tr>
            `);
        });

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('detalles').value = JSON.stringify(productos);
    }

    function agregarProducto() {
        const select = document.getElementById('producto_select');
        const id = select.value ? parseInt(select.value) : null;
        const nombre = select.options[select.selectedIndex]?.dataset?.nombre || '';
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const precio = parseFloat(document.getElementById('precio').value);

        if (!id || isNaN(cantidad) || isNaN(precio) || cantidad <= 0 || precio <= 0) {
            return alert('Complete correctamente todos los campos del producto');
        }

        const existente = productos.find(p => p.idproducto === id);
        if (existente) {
            existente.cantidad += cantidad;
            existente.precio = precio;
        } else {
            productos.push({ idproducto: id, nombre, cantidad, precio });
        }

        select.value = '';
        document.getElementById('cantidad').value = '';
        document.getElementById('precio').value = '';
        actualizarTabla();
    }

    function eliminarProducto(i) {
        productos.splice(i, 1);
        actualizarTabla();
    }

    function editarCantidad(i, val) {
        productos[i].cantidad = parseInt(val);
        actualizarTabla();
    }

    function editarPrecio(i, val) {
        productos[i].precio = parseFloat(val);
        actualizarTabla();
    }

    document.getElementById('agregarProducto').addEventListener('click', agregarProducto);
</script>

@endsection
