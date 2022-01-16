<?php

namespace App\Models\Compras;

use App\Models\Administracion\Proveedor;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Mantenimiento\Almacen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoCompra extends Model
{
    use HasFactory;
    protected $table = "documento_compra";
    protected $fillable = [
        'proveedor_id',
        'almacen_id',
        'ruta_imagen',
        'nombre_imagen',
        'tipo_documento_id',
        'numeracion',
        'fecha_emision',
        'fecha_entrega',
        'modo_compra',
        'tipo_moneda',
        'igv',
        'cantidad_igv',
        'total',
        'estado'
    ];
    public $timestamp = true;
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    public function detalle()
    {
        return $this->hasMany(DetalleDocumentoCompra::class, 'documento_compra_id');
    }
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id');
    }
}
