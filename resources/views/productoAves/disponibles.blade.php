@extends('plantillas.inicio')

@section('h1', 'Productos disponibles')

@section('contenido')
<div class="container">

    <h2>Productos disponibles</h2>

    <form method="GET" action="{{ route('reportes.productos.disponibles') }}" style="margin-bottom:20px;">
        <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:end;">
            <div>
                <label>Buscar</label><br>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nombre o categoría">
            </div>

            <div>
                <label>Categoría</label><br>
                <select name="categoria_id">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @if(request('categoria_id') == $cat->id) selected @endif>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Precio min</label><br>
                <input type="number" step="0.01" name="precio_min" value="{{ request('precio_min') }}">
            </div>

            <div>
                <label>Precio max</label><br>
                <input type="number" step="0.01" name="precio_max" value="{{ request('precio_max') }}">
            </div>

            <div>
                <label>Ordenar</label><br>
                <select name="orden">
                    <option value="nombre_asc" @if(request('orden')=='nombre_asc') selected @endif>Nombre ↑</option>
                    <option value="price_asc" @if(request('orden')=='price_asc') selected @endif>Precio ↑</option>
                    <option value="price_desc" @if(request('orden')=='price_desc') selected @endif>Precio ↓</option>
                    <option value="cantidad_desc" @if(request('orden')=='cantidad_desc') selected @endif>Cantidad ↓</option>
                </select>
            </div>

            <div>
                <button type="submit" style="padding:6px 12px; background:#ef8504; color:white; border:none; border-radius:5px;">
                    Filtrar
                </button>
            </div>

            <div>
                <a href="{{ route('reportes.productos.disponibles') }}" style="padding:6px 12px; background:#ddd; color:#333; border-radius:5px; text-decoration:none;">
                    Limpiar
                </a>
            </div>
        </div>
    </form>

    @if($productos->isEmpty())
        <p>No hay productos con stock disponible.</p>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:#ef8504; color:white;">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $p)
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="width:100px; text-align:center;">
                            @if($p->fotoaves->first())
                                <img src="{{ asset('storage/imagenes/'.$p->fotoaves->first()->nombrefoto) }}" alt="" style="width:80px; height:60px; object-fit:cover; border-radius:6px;">
                            @else
                                <div style="width:80px; height:60px; background:#f4f4f4; display:flex; align-items:center; justify-content:center; color:#999; border-radius:6px;">No img</div>
                            @endif
                        </td>
                        <td>{{ $p->nombre }}</td>
                        <td>{{ $p->categoria->nombre ?? 'N/A' }}</td>
                        <td>Bs {{ number_format($p->precio, 2) }}</td>
                        <td>{{ $p->cantidad }}</td>
                        <td>
                            <a href="{{ route('productoaves.show', $p->id) ?? '#' }}" style="text-decoration:none; color:#ef8504;">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $productos->links() }} {{-- paginación --}}
        </div>
    @endif
</div>
@endsection
