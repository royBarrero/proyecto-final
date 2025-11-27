<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedors';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'activo',
        'idusuarios',   // FK usuario
    ];

    // Relación con usuarios
  public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'idusuarios', 'id');
    }

    /**
     * Relación: Un vendedor puede tener muchos pedidos
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'idvendedors', 'id');
    }

    /**
     * Relación: Un vendedor puede tener muchas compras
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'idvendedors', 'id');
    }
}
