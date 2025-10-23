@extends('plantillas.inicio')
@section('h1', 'Detalles de Aves')

@section('contenido')
<div class="container">
    <h2>Lista de Detalles de Aves</h2>
    <x-alerta />

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Edad (días)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
        @forelse($detalleaves ?? [] as $detalle)
            <tr>
                <td data-label="ID">{{ ++$i }}</td>
                <td data-label="Descripción">{{ $detalle->descripcion }}</td>
                <td data-label="Edad">{{ $detalle->edad }}</td>
                <td data-label="Acciones">
                    <div class="div-botones">
                        
                        <a href="{{ route('detalleaves.edit', $detalle->id) }}" class="btn-editar">Editar</a>
                        <form action="{{ route('detalleaves.destroy', $detalle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este detalle?\n{{ $detalle->descripcion }}')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">No hay registros disponibles.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="div-botones2">
        <a href="{{ route('detalleaves.create') }}" class="btn-editar">Nuevo Detalle</a>
        <a href="{{ url()->previous() }}" class="btn-eliminar">Volver</a>
    </div>
</div>
@endsection


