@extends('plantillas.inicio')
@section('h1','Proveedores')

@section('contenido')
<div class="container">
    <h2>Lista de Proveedores</h2>
    <x-alerta />

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @php $i = 0; @endphp
        @foreach($proveedores ?? [] as $prov)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Nombre">{{ $prov->nombre }}</td>
                <td data-label="Dirección">{{ $prov->direccion }}</td>
                <td data-label="Teléfono">{{ $prov->telefono }}</td>
                <td data-label="Acciones">
                    <div class="div-botones">
                        <a href="{{ route('proveedores.edit',$prov->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('proveedores.destroy',$prov->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este proveedor: {{ $prov->nombre }}?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        <a href="{{ route('proveedores.create') }}" class="btn-editar">Nuevo Proveedor</a>
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
