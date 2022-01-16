<?php

namespace App\Models\Almacen;

use App\Models\Mantenimiento\Almacen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaIngreso extends Model
{
    use HasFactory;
    protected $table="nota_ingreso";
    protected $fillable=[
        'user_id',
        'almacen_id',
        'fecha_emision',
        'descripcion',
        'codigo',
        'estado'
    ];
    public $timestamps=true;
    public function detalle()
    {
        return $this->hasMany(DetalleNotaIngreso::class,'nota_ingreso_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
}
