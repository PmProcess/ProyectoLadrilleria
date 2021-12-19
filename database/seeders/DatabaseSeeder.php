<?php

namespace Database\Seeders;

use App\Models\Configuracion\TipoMoneda;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsuarioAdminSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(ApiSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(TipoPagoSeeder::class);
        $this->call(FormaPagoSeeder::class);
        $this->call(TipoMonedaSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(TipoProductoSeed::class);

    }
}
