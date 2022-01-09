<?php

namespace Database\Seeders;

use App\Models\Mantenimiento\UnidadMedida;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedida::create([
            'simbolo'=>'NIU',
            'descripcion'=>'unidades'
        ]);
    }
}
