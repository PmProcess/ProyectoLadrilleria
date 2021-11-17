<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    protected $table="tipo_documento";
    protected $fillable=[
        'tipo','descripcion'
    ];
    public $timestamps=true;
}
