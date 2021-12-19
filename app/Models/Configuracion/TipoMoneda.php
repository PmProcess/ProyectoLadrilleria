<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMoneda extends Model
{
    use HasFactory;
    protected $table="tipo_moneda";
    protected $fillable=[
        'tipo',
        'estado'
    ];
    public $timestamps=true;
}
