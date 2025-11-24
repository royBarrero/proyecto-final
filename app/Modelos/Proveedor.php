<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedors';   // Nombre correcto de la tabla
    protected $primaryKey = 'id';
    public $timestamps = false;         // No hay created_at ni updated_at

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    // 🔗 Aquí podrías agregar relaciones si lo necesitas
    // Por ejemplo, productos que pertenezcan a este proveedor:
    // public function productos()
    // {
    //     return $this->hasMany(Productoave::class, 'idproveedor', 'id');
    // }
    /**
     * Relación: Un proveedor puede tener muchas compras
     */
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'idproveedors');
    }
}
