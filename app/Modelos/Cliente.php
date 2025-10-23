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
        'telefono',
        'activo',
    ];


    // Relación con usuarios (1 cliente puede tener varios usuarios, si es el caso)
    // Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idusuarios');
    }
}
