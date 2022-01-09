<?php

namespace App\Models\Ventas;

use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table="pago";
    protected $fillable=[
        'documento_venta_id',
        'efectivo',
        'transferencia',
        'forma_pago_id',
        'url_imagen',
        'nombre_imagen'
    ];
    public function formaPago()
    {
        return $this->belongsTo(FormaPago::class,'forma_pago_id');
    }
    public function documentoVenta()
    {
        return $this->belongsTo(DocumentoVenta::class,'documento_venta_id');
    }
}
