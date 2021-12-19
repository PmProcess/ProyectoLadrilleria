<?php

namespace Database\Seeders;

use App\Models\Configuracion\TipoMoneda;
use Illuminate\Database\Seeder;

class TipoMonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMoneda::create([
            'tipo'=>"SOLES",
            'estado'=>"ACTIVO"
        ]);

        TipoMoneda::create([
            'tipo'=>"DOLARES",
            'estado'=>"ACTIVO"
        ]);
    }
}
