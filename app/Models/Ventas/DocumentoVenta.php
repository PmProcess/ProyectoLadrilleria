<?php

namespace App\Models\Ventas;

use App\Models\Administracion\Cliente;
use App\Models\Administracion\Empleado;
use App\Models\Configuracion\NumeracionConteo;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoPago;
use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoVenta extends Model
{
    use HasFactory;
    protected $table="documento_venta";
    protected $fillable=[
        'cliente_id',
        'user_id',
        // 'forma_pago_id',
        'correlativo_id',
        'cotizacion_id',
        'tipo_documento_id',
        'fecha_registro',
        'fecha_vencimiento',
        // 'tipo_moneda_id',
        'estado_documento',
        'url_qr',
        'deuda',
        'total',
        'estado',
        'nombre_comprobante_archivo',
        'hash',
        'url_comprobante_archivo'
    ];
    public $timestamps=true;
    // public function tipoMoneda()
    // {
    //     return $this->belongsTo(tipoMoneda::class,'tipo_moneda_id');
    // }
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class,'cotizacion_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class,'empleado_id');
    }
    // public function formaPago(){
    //     return $this->belongsTo(FormaPago::class,'forma_pago_id');
    // }
    public function correlativo(){
        return $this->belongsTo(NumeracionConteo::class,"correlativo_id");
    }
    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id');
    }
    public function detalle(){
        return $this->hasMany(DetalleDocumentoVenta::class,'documento_venta_id');
    }
    public function pagos(){
        return $this->hasMany(Pago::class,'documento_venta_id');
    }
    public function enviosSunat()
    {
        return $this->hasMany(EnvioSunat::class,'documento_venta_id');
    }
    public function envioExitosoSunat()
    {
        return $this->hasOne(EnvioSunat::class,'documento_venta_id')->where('envio_sunat.estado','ACEPTADO');
    }
}
