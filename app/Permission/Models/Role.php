<?php

namespace App\Permission\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug',
        'description','full-access','eliminar'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
