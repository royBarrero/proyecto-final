@extends('plantillas.inicio')
@section('h1','Proveedores')

@section('contenido')
<style>
    .proveedores-container {
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

    .header-actions {
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

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: stretch;
        }

        .header-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="proveedores-container">
    <!-- Header con botones de exportación -->
    <div class="header-section">
        <h2>🏢 Lista de Proveedores</h2>
        
        <div class="header-actions">
            <a href="{{ route('proveedores.exportar.excel') }}" class="btn btn-excel">
                📊 Exportar Excel
            </a>
            <a href="{{ route('proveedores.exportar.pdf') }}" class="btn btn-pdf" target="_blank">
                📄 Exportar PDF
            </a>
        </div>
    </div>

    <div class="container">
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
</div>
@endsection