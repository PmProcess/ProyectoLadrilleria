<?php

namespace App\Models\Ventas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ventas\Producto;

class DetalleCotizacion extends Model
{
    use HasFactory;
    protected $table="detalle_cotizacion";
    protected $fillable=[
        'cotizacion_id',
        'producto_id',
        'cantidad',
        'precio',
        'descripcion'
    ];
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class,'cotizacion_id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
