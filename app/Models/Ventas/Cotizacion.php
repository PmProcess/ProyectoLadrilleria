<?php

namespace App\Models\Ventas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Administracion\Cliente;
use App\Models\User;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table="cotizacion";
    protected $fillable=[
        'cliente_id',
        'user_id',
        'estado_cotizacion',
        'estado',
        'total'
    ];
    public function detalle()
    {
        return $this->hasMany(DetalleCotizacion::class,'cotizacion_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
