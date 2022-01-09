<?php

namespace App\Models\Compras;

use App\Models\Mantenimiento\UnidadMedida;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    protected $table="insumo";
    protected $fillable=[
        'codigo',
        'precio',
        'stock',
        'unidad_medida_id',
        'nombre',
        'nombre_imagen',
        'url_imagen',
        'estado'
    ];
    public $timestamps = true;
    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class,'unidad_medida_id');
    }
}
