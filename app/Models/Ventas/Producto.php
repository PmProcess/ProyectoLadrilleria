<?php

namespace App\Models\Ventas;

use App\Models\Mantenimiento\UnidadMedida;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table="producto";
    protected $fillable=[
        'tipo_producto_id',
        'precio_venta',
        // 'tipo_operacion',
        'stock',
        'nombre',
        'nombre_imagen',
        'unidad_medida_id',
        'url_imagen',
        'codigo',
        'estado'
    ];
    public $timestamps = true;
    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class,'tipo_producto_id');
    }
    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class,'unidad_medida_id');
    }
}
