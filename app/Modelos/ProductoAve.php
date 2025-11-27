<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Modelos\Detalleave;
use App\Modelos\Categoria;
use App\Modelos\Fotoave;
use App\Modelos\DetallePedido;
use App\Modelos\DetalleCotizacion;
use App\Modelos\Stock;

class ProductoAve extends Model
{
    protected $table = 'productoaves';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'idcategorias',
        'iddetalleaves',
        'cantidad'
    ];

    // 🔗 Relación con FotoAve (1 producto puede tener muchas fotos)
    public function fotoaves(): HasMany
    {
        return $this->hasMany(Fotoave::class, 'idproductoaves', 'id');
    }

    // 🔗 Relación con DetalleAve (1 producto pertenece a 1 detalle)
    public function detalleAve(): BelongsTo
    {
        return $this->belongsTo(Detalleave::class, 'iddetalleaves', 'id');
    }

    // 🔗 Relación con Categoría (1 producto pertenece a 1 categoría)
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'idcategorias', 'id');
    }
    
    /**
     * Relación: Un producto ave puede estar en muchos detalles de pedidos
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'idproductoaves');
    }

    /**
     * Relación: Un producto ave puede estar en muchas cotizaciones
     */
    public function detalleCotizaciones(): HasMany
    {
        return $this->hasMany(DetalleCotizacion::class, 'idproductoaves');
    }

    /**
     * Relación: Un producto ave puede tener muchos stocks
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'idproductoaves');
    }
}