<?php

namespace App\Http\Controllers;
use App\Models\Ventas\Producto;
use Illuminate\Http\Request;
use App\Models\Ventas\Cotizacion;
use App\Models\Ventas\DetalleCotizacion;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getProductos()
    {
        return Producto::where('estado','ACTIVO')->get()->map(function($producto){
            $producto->img=$producto->url_imagen?"http://" . $_SERVER['SERVER_NAME'] . "/" . str_replace('public', 'storage', $producto->url_imagen):null;
            return $producto;
        });
    }
    public function storeCotizacion(Request $request)
    {
        DB::beginTransaction();
        try{
            Log::info($request);
            $detalle=json_decode($request->detalle_cotizacion);
            $cotizacion= new Cotizacion();
            $cotizacion->cliente_id=User::findOrFail($request->user_id)->cliente->id;
            $cotizacion->total=$request->total;
            $cotizacion->save();
            foreach($detalle as $item)
            {
                $detalle=new DetalleCotizacion();
                $detalle->cotizacion_id=$cotizacion->id;
                $detalle->producto_id=$item->producto_id;
                $detalle->cantidad=$item->cantidad;
                $detalle->precio=$item->precio;
                $detalle->descripcion=$item->descripcion;
                $detalle->save();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Registro con Exito"
            ]);
        }
        catch(\Exception $e)
        {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Ocurrio un error"
            ]);
        }
    }
    public function getCotizaciones(Request $request)
    {
        $user=$request->user();
        $cliente=$user->cliente;
        return Cotizacion::where('estado','ACTIVO')->where('cliente_id',$cliente->id)->with(['detalle.producto'])->get()->map(function($cotizacion){
            $cotizacion->nombre="Cotizacion -".$cotizacion->id;
            $cotizacion->fecha=$cotizacion->created_at->format('Y-m-d');
            return $cotizacion;
        });
    }
    public function deleteCotizacion(Request $request)
    {
        DB::beginTransaction();
        try{
            $cotizacion=Cotizacion::findOrFail($request->id);
            if($cotizacion->estado_cotizacion=="COTIZADO")
            {
                return response()->json([
                    'success' => false,
                    'message' => "Este Documento ya tine un Documento de Venta"
                ]); 
            }
            $cotizacion->estado="ANULADO";
            $cotizacion->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Eliminado con Exito"
            ]);
        }
        catch(\Exception $e)
        {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Ocurrio un error"
            ]);
        }
    }
}
