<?php

namespace Database\Seeders;

use App\Models\Mantenimiento\EmpresaPersonal;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmpresaPersonal::create([
            'ruc'=>'000000000000',
            'razon_social'=>'NN',
            'nombre_comercial'=>'NN',
            'direccion'=>'NN',
            'direccion_fiscal'=>'NN',
            'telefono'=>'123456789',
            'correo'=>'correo@admin.com'
        ]);
    }
}
