@extends('plantillas.inicio')

@section('h1', 'Compras registradas')

@section('contenido')
<div class="container">

    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($compras->isEmpty())
        <p>No hay compras registradas.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#ef8504; color:white;">
                    <th style="padding:10px; border:1px solid #ddd;">ID</th>
                    <th style="padding:10px; border:1px solid #ddd;">Fecha</th>
                    <th style="padding:10px; border:1px solid #ddd;">Proveedor</th>
                    <th style="padding:10px; border:1px solid #ddd;">Total</th>
                    <th style="padding:10px; border:1px solid #ddd;">Estado</th>
                    <th style="padding:10px; border:1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $compra)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $compra->id }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $compra->fecha }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $compra->proveedor->nombre }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">Bs {{ number_format($compra->total, 2) }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $compra->estado }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            <a href="{{ route('compras.show', $compra->id) }}" style="margin-right:5px; color:#ef8504; font-weight:bold;">Ver</a>
                            <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;" onclick="return confirm('¿Eliminar compra ID {{ $compra->id }}?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="margin-top:15px;">
        <a href="{{ route('compras.create') }}" style="padding:8px 15px; background:#ef8504; color:white; border-radius:5px; text-decoration:none; font-weight:bold;">Registrar nueva compra</a>
    </div>

</div>
@endsection
