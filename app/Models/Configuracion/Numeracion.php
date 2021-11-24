<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeracion extends Model
{
    use HasFactory;
    protected $table = "numeracion";
    protected $fillable = [
        'serie',
        'correlativo_iniciar',
        'tipo_documento_id',
        'estado', 'seleccionado'
    ];
    public $timestamps = true;
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    public function conteo()
    {
        return $this->hasMany(NumeracionConteo::class, 'numeracion_id');
    }
}
