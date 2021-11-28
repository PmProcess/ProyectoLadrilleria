<?php

namespace App\Models\Ventas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDocumentoVenta extends Model
{
    use HasFactory;
    protected $table="detalle_documento_venta";
    protected $fillable=[
        'documento_venta_id',
        'producto_id',
        'cantidad',
        'precio',
        'estado'
    ];
    public $timestamps=true;
    public function documentoVenta()
    {
        return $this->belongsTo(DocumentoVenta::class,'documento_venta_id');
    }

}
