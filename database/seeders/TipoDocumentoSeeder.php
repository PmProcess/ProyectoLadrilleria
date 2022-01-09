<?php

namespace Database\Seeders;

use App\Models\Configuracion\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create([
            'tipo'=>'Boleta de Venta'
        ]);
        TipoDocumento::create([
            'tipo'=>'Factura de Venta'
        ]);
        TipoDocumento::create([
            'tipo'=>'Recibo de Venta'
        ]);

    }
}
