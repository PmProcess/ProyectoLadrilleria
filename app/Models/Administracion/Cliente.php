<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    protected $fillable = [
        'persona_id',
        'user_id',
        'url_imagen',
        'nombre_imagen',
        'tipo'
    ];
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
