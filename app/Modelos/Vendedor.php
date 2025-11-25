<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idusuarios');
    }

    /**
     * Relación: Un vendedor puede tener muchos pedidos
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'idvendedors');
    }

    /**
     * Relación: Un vendedor puede tener muchas compras
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'idvendedors');
    }
}
