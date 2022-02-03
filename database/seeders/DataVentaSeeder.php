<?php

namespace Database\Seeders;

use App\Models\Configuracion\TipoDocumento;
use App\Models\User;
use App\Models\Ventas\DetalleDocumentoVenta;
use App\Models\Ventas\DocumentoVenta;
use App\Models\Ventas\Pago;
use App\Models\Ventas\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            for ($i = 0; $i < 3000; $i++) {
                DB::beginTransaction();
                $numerosProductos = Producto::where('estado','ACTIVO')->count();
                $tipoDocumento = rand(1, 2);
                $cliente = DB::table('cliente as c')
                    ->join('persona as p', 'p.id', '=', 'c.persona_id')
                    ->where('p.estado', 'ACTIVO')
                    ->where('p.tipo_documento', $tipoDocumento == 1 ? 'DNI' : 'RUC')
                    ->select('c.id')->inRandomOrder()->first();
                $total = 0;
                $correlativo_id = obtenerCorrelativo(TipoDocumento::findOrFail($tipoDocumento))->id;
                $documento = new DocumentoVenta();
                $documento->cliente_id = $cliente->id;
                $documento->user_id = 1; //Administrador
                $documento->correlativo_id = $correlativo_id;
                $documento->tipo_documento_id = $tipoDocumento;
                $frand= self::randomDate('01/01/2019', '12/24/2021');
                $documento->fecha_registro =$frand;
                $documento->fecha_vencimiento = $frand;
                $documento->total = $total;
                $documento->deuda = $total;
                $documento->save();
                $cantidadProcutos = rand(1, $numerosProductos);
                for ($j = 1; $j <= $cantidadProcutos; $j++) {
                    $detalle = self::registrarDetalle($documento);
                    $total += ($detalle->precio * $detalle->cantidad);
                }
                $documento->total = $total;
                $documento->deuda = $total;
                $documento->save();

                $pagoDocumento = new Pago();
                $pagoDocumento->documento_venta_id = $documento->id;
                $pagoDocumento->efectivo = $total;
                $pagoDocumento->transferencia = 0;
                $pagoDocumento->forma_pago_id = rand(1, 3);
                $pagoDocumento->save();

                DB::commit();
            }
        } catch (\Exception $th) {
            //throw $th;
            Log::info($th);
            DB::rollBack();
        }
    }
    public static function registrarDetalle($documento)
    {
        $producto = Producto::where('estado', 'ACTIVO')->inRandomOrder()->first();
        if (DetalleDocumentoVenta::where('documento_venta_id', $documento->id)->where('producto_id', $producto->id)->count() == 0) {
            $detalle = new DetalleDocumentoVenta();
            $detalle->producto_id = $producto->id;
            $detalle->documento_venta_id = $documento->id;
            $detalle->cantidad = rand(200, 1000);
            $detalle->precio = $producto->precio_venta;
            $detalle->save();
            return $detalle;
        }
        return self::registrarDetalle($documento);
    }
    public static function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }
}
