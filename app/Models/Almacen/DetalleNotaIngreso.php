<?php

namespace App\Models\Almacen;

use App\Models\Ventas\Producto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNotaIngreso extends Model
{
    use HasFactory;
    protected $table = "detalle_nota_ingreso";
    protected $fillable = [
        'nota_ingreso_id',
        'producto_id',
        'cantidad',
        'fecha_vencimiento'
    ];
    public $timestamps = true;
    public function notaIngreso()
    {
        return $this->belongsTo(NotaIngreso::class, 'nota_ingreso_id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    protected static function booted()
    {
        static::created(function ($detalle) {
            $producto = Producto::findOrFail($detalle->producto_id);
            $producto->stock += $detalle->cantidad;
            $producto->save();
        });
    }
}
