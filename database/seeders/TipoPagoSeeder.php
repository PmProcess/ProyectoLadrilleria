<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion\TipoPago;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPago::create([
            "tipo"=>"CONTADO",
            "dias"=>0
        ]);

        TipoPago::create([
            "tipo"=>"CREDITO",
            "dias"=>7
        ]);

        TipoPago::create([
            "tipo"=>"CREDITO",
            "dias"=>15
        ]);

        TipoPago::create([
            "tipo"=>"CREDITO",
            "dias"=>30
        ]);
    }
}
