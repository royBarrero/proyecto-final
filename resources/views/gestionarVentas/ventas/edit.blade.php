@extends('plantillas.inicio')
@section('h1','Editar Venta')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('editar_ventas'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="form-box">
    <form id="ventaForm" action="{{ route('ventas.update',$venta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Cliente</label>
            <select name="id_cliente" required>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ $venta->id_cliente == $c->id ? 'selected' : '' }}>
                        {{ $c->idusuarios }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Vendedor</label>
            <select name="id_vendedor" required>
                @foreach($vendedores as $v)
                    <option value="{{ $v->id }}" {{ $venta->id_vendedor == $v->id ? 'selected' : '' }}>
                        {{ $v->idusuarios }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Método de Pago</label>
            <select name="metodo_pago" required>
                @foreach($metodos as $m)
                    <option value="{{ $m->id }}" {{ $venta->metodo_pago == $m->id ? 'selected' : '' }}>
                        {{ $m->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Detalle de Productos</h3>

        <div style="display:flex; gap:10px;">
            <input type="number" id="id_producto" placeholder="ID Producto" style="width:120px;">
            <input type="number" id="cantidad" placeholder="Cantidad" style="width:120px;">
            <input type="number" id="precio" placeholder="Precio" step="0.01" style="width:120px;">
            <button type="button" id="agregarProducto" class="btn-editar">Agregar</button>
        </div>

        <table id="tablaProductos" class="styled-table" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>ID</th>
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
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-cerrar">Volver</a>
        </div>
    </form>
</div>

<script>
    let productos = {!! json_encode($venta->detalles) !!};
    const tbody = document.querySelector('#tablaProductos tbody');

    function actualizarTabla() {
        tbody.innerHTML = '';
        let total = 0;
        productos.forEach((p,i)=>{
            const subtotal = p.cantidad * p.precio;
            total += subtotal;
            tbody.insertAdjacentHTML('beforeend',`
                <tr>
                    <td>${p.idproducto}</td>
                    <td><input type="number" value="${p.cantidad}" min="1" onchange="editarCantidad(${i}, this.value)"></td>
                    <td><input type="number" value="${p.precio}" step="0.01" onchange="editarPrecio(${i}, this.value)"></td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn-eliminar" onclick="eliminarProducto(${i})">Eliminar</button></td>
                </tr>`);
        });
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('detalles').value = JSON.stringify(productos);
    }

    function agregarProducto() {
        const id = parseInt(document.getElementById('id_producto').value);
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const precio = parseFloat(document.getElementById('precio').value);
        if (!id || !cantidad || !precio) return alert('Complete todos los campos');
        const existente = productos.find(p=>p.idproducto===id);
        if (existente) {
            existente.cantidad += cantidad;
            existente.precio = precio;
        } else {
            productos.push({idproducto:id, cantidad, precio});
        }
        document.getElementById('id_producto').value='';
        document.getElementById('cantidad').value='';
        document.getElementById('precio').value='';
        actualizarTabla();
    }

    function eliminarProducto(i){ productos.splice(i,1); actualizarTabla(); }
    function editarCantidad(i,val){ productos[i].cantidad=parseInt(val); actualizarTabla(); }
    function editarPrecio(i,val){ productos[i].precio=parseFloat(val); actualizarTabla(); }
    document.getElementById('agregarProducto').addEventListener('click',agregarProducto);
    actualizarTabla();
</script>
@endsection
