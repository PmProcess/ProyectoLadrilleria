<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DetalleDocumentoCompra extends Model
{
    use HasFactory;
    protected $table = "detalle_documento_compra";
    protected $fillable = [
        'documento_compra_id',
        'insumo_id',
        'cantidad',
        'precio'
    ];
    public $timestamp = true;

    public function documentoCompra()
    {
        return $this->belongsTo(DocumentoCompra::class, 'documento_compra_id');
    }
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
    protected static function booted()
    {
        static::created(function ($detalle) {
            $insumo = Insumo::findOrFail($detalle->insumo_id);
            $insumo->stock += $detalle->cantidad;
            $insumo->save();
        });
    }
}
