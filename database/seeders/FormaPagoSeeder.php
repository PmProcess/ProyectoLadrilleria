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
            "tipo"=>"PLINK"
        ]);
        FormaPago::create([
            "tipo"=>"YAPE"
        ]);
        FormaPago::create([
            "tipo"=>"EFECTIVO"
        ]);
    }
}
