@extends('plantillas.inicio')

@section('h1', 'Registrar nueva compra')

@section('contenido')
<div class="container">
    {-- Validar permiso --}
    @if(!auth()->user()->tienePermiso('crear_compras'))
        <div class="alert alert-danger">
            <strong>Acceso Denegado:</strong> No tienes permisos para realizar esta acción.
        </div>
        @php
            abort(403, 'No tienes permisos suficientes');
        @endphp
    @endif
    
<div class="container">

    @if($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:5px; margin-bottom:15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('compras.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:10px;">
            <label for="idproveedors" style="font-weight:bold;">Proveedor:</label>
            <select name="idproveedors" id="idproveedors" style="padding:8px; border-radius:5px; border:1px solid #ccc; width:100%;">
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label style="font-weight:bold;">Productos:</label>
            <div id="productosContainer">
                <div class="productoRow" style="display:flex; gap:10px; margin-bottom:5px;">
                    <select name="productos[0][idproductoalimentos]" style="flex:2; padding:5px;">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="productos[0][cantidad]" placeholder="Cantidad" style="flex:1; padding:5px;" min="1">
                    <input type="number" name="productos[0][preciounitario]" placeholder="Precio unitario" style="flex:1; padding:5px;" min="0" step="0.01">
                    <button type="button" onclick="eliminarProducto(this)" style="flex:0; color:red; border:none; background:none; cursor:pointer;">✖</button>
                </div>
            </div>
            <button type="button" onclick="agregarProducto()" style="padding:5px 10px; margin-top:5px; background:#ef8504; color:white; border:none; border-radius:5px;">Agregar producto</button>
        </div>

        <div>
            <button type="submit" style="padding:10px 15px; background:#ef8504; color:white; border:none; border-radius:5px; font-weight:bold;">Registrar compra</button>
        </div>
    </form>

</div>

<script>
    let productoIndex = 1;

    function agregarProducto() {
        const container = document.getElementById('productosContainer');
        const newRow = document.createElement('div');
        newRow.classList.add('productoRow');
        newRow.style.display = 'flex';
        newRow.style.gap = '10px';
        newRow.style.marginBottom = '5px';
        newRow.innerHTML = `
            <select name="productos[${productoIndex}][idproductoalimentos]" style="flex:2; padding:5px;">
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
            <input type="number" name="productos[${productoIndex}][cantidad]" placeholder="Cantidad" style="flex:1; padding:5px;" min="1">
            <input type="number" name="productos[${productoIndex}][preciounitario]" placeholder="Precio unitario" style="flex:1; padding:5px;" min="0" step="0.01">
            <button type="button" onclick="eliminarProducto(this)" style="flex:0; color:red; border:none; background:none; cursor:pointer;">✖</button>
        `;
        container.appendChild(newRow);
        productoIndex++;
    }

    function eliminarProducto(btn) {
        btn.parentElement.remove();
    }
</script>
@endsection
