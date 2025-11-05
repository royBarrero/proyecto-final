<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Http\Controladores\Controlador;
use App\Modelos\ProductoAve;
use App\Modelos\Categoria;

class ProductoDisponibleControlador extends Controlador
{
    /**
     * Mostrar productos disponibles con filtros, orden y paginación.
     */
    public function index(Request $request)
    {
        // Categorías para filtros
        $categorias = Categoria::orderBy('nombre')->get();

        // Solo productos con stock > 0
        $query = ProductoAve::with(['categoria', 'fotoaves', 'detalleAve'])
            ->where('cantidad', '>', 0);

        // Filtro por nombre o categoría
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($qry) use ($q) {
                $qry->where('nombre', 'ilike', "%{$q}%")
                    ->orWhereHas('categoria', function($q2) use ($q) {
                        $q2->where('nombre', 'ilike', "%{$q}%");
                    });
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('idcategorias', $request->categoria_id);
        }

        // Filtro por rango de precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Ordenamiento
        $orden = $request->get('orden', 'nombre_asc');
        switch ($orden) {
            case 'price_asc': $query->orderBy('precio', 'asc'); break;
            case 'price_desc': $query->orderBy('precio', 'desc'); break;
            case 'cantidad_desc': $query->orderBy('cantidad', 'desc'); break;
            default: $query->orderBy('nombre', 'asc');
        }

        // Paginación
        $productos = $query->paginate(20)->withQueryString();

        return view('productoaves.disponibles', compact('productos', 'categorias'));
    }
}
