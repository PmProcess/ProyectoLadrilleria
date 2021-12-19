<?php

namespace Database\Seeders;

use App\Models\Ventas\TipoProducto;
use Illuminate\Database\Seeder;

class TipoProductoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoProducto::create([
            'tipo'=>'ladrillo',
        ]);
    }
}
