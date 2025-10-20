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
        'idusuarios',   // FK usuario
        'direccion',
        'telefono',
        'email',
        'activo',
    ];

    // Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idusuarios');
    }

}
