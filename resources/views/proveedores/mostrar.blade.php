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
                @if(auth()->user()->tieneAlgunPermiso(['editar_proveedores', 'eliminar_proveedores']))

                    <th>Acciones</th>

                @endif
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
                @if(auth()->user()->tieneAlgunPermiso(['editar_proveedores', 'eliminar_proveedores']))

                <td data-label="Acciones">
                    <div class="div-botones">
                        @if(auth()->user()->tienePermiso('editar_proveedores'))
                            <a href="{{ route('proveedores.edit',$prov->id) }}" class="btn-editar">Editar</a>
                        @endif
                        <form action="{{ route('proveedores.destroy',$prov->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este proveedor: {{ $prov->nombre }}?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="div-botones2">
        @if(auth()->user()->tienePermiso('crear_proveedores'))
            <a href="{{ route('proveedores.create') }}" class="btn-editar">Nuevo Proveedor</a>
        @endif
        <a href="{{ route('bienvenido.usuarios.vendedor') }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection
