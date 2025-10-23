<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\Productoave;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function productoAve()
    {
        return $this->hasOne(Productoave::class, 'idcategorias', 'id');
    }
}
