<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeracionConteo extends Model
{
    use HasFactory;
    protected $table="numeracion_conteo";
    protected $fillable=[
        'correlativo',
        'numeracion_id'
    ];
    public $timestamps=true;
    public function numeracion(){
        return $this->belongsTo(Numeracion::class,'numeracion_id');
    }
}
