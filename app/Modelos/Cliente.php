<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\Usuario;
class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';   // nombre tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idusuarios',   // FK usuario
        'direccion',
        'nombre',
        'telefono',
        'activo',
    ];


    // Relación con usuarios (1 cliente puede tener varios usuarios, si es el caso)
    // Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idusuarios');
    }

    /**
     * Relación: Un cliente puede tener muchos pedidos
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'idclientes');
    }

    /**
     * Relación: Un cliente puede tener muchas cotizaciones
     */
    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'idclientes');
    }
}
