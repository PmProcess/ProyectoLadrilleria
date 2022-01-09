<?php

namespace App\Models\Ventas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioSunat extends Model
{
    use HasFactory;
    protected $table="envio_sunat";
    protected $fillable=[
        'documento_venta_id',
        'cdr_response',
        'id_response',
        'message_response',
        'codigo',
        'descripcion',
        'estado'
    ];
    public $timestamps=true;
    public function documentoVenta()
    {
        return $this->belongsTo(DocumentoVenta::class,'documento_venta_id');
    }

}
