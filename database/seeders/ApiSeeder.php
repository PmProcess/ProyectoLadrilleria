<?php

namespace Database\Seeders;

use App\Models\Apis;
use Illuminate\Database\Seeder;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Apis::create([
            "http"=>"https://apiperu.dev/api/dni/",
            "descripcion" =>"dni"
        ]);
        Apis::create([
            "http"=>"https://apiperu.dev/api/ruc/",
            "descripcion" =>"ruc"
        ]);
        Apis::create([
            "http"=>"https://facturacion.apisperu.com/api/v1"
        ]);
    }
}
