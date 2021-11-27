<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    use HasFactory;
    protected $table="tipo_pago";
    protected $fillable=[
        'tipo',
        'dias'
    ];
    public $timestamps=true;
}
