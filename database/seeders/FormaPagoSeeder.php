<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormaPago::create([
            "tipo"=>"Tarjeta"
        ]);
        FormaPago::create([
            "tipo"=>"Efectivo"
        ]);
    }
}
