<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Proveedor;
use App\Models\Mantenimiento\EmpresaPersonal;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    public function index()
    {
        $tiempophp = microtime(true);
        return view('reportes.reporte.index',compact('tiempophp'));
    }
    public function getVentas(Request $request)
    {

        $rango = new CarbonPeriod($request->fechaInicial, $request->fechaFinal);
        $fechas = array();
        $data = array();
        foreach ($rango as $key => $value) {
            $consulta = DB::table('documento_venta as dv')
                ->join('detalle_documento_venta as dcv', 'dcv.documento_venta_id', '=', 'dv.id')
                ->whereDate('dv.fecha_registro', $value->format('Y-m-d'))
                ->select(DB::raw('sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('date(dv.fecha_registro)')
                ->when($request->input('estado'), function ($query, $estado) {
                    return $query->where('dv.estado_documento', $estado);
                });
            array_push($fechas, $value->format('Y-m-d'));
            array_push($data, $consulta->count() == 0 ? 0 : $consulta->first()->total);
        }
        return array("fechas" => $fechas, "data" => $data);
    }
    public function getProductos(Request $request)
    {
        return DB::table('documento_venta as dv')
            ->join('detalle_documento_venta as dcv', 'dcv.documento_venta_id', '=', 'dv.id')
            ->join('producto as p', 'p.id', '=', 'dcv.producto_id')
            ->select(DB::raw('p.nombre,sum(dcv.cantidad) as cuenta'))
            ->when($request->input('fechaInicial'), function ($query, $fechaInicial) {
                return $query->whereDate('dv.fecha_registro', '>=', $fechaInicial);
            })
            ->when($request->input('fechaFinal'), function ($query, $fechaFinal) {
                return $query->whereDate('dv.fecha_registro', '<=', $fechaFinal);
            })
            ->groupByRaw('p.nombre')
            ->take(3)->get();
    }
    public function getAlmacen(Request $request)
    {
        return DB::table('documento_compra as dc')
            ->join('detalle_documento_compra as ddc', 'ddc.documento_compra_id', '=', 'dc.id')
            ->join('almacen as a', 'a.id', '=', 'dc.almacen_id')
            ->select(DB::raw('a.nombre,sum(ddc.cantidad) as cuenta'))
            ->when($request->input('fechaInicial'), function ($query, $fechaInicial) {
                return $query->whereDate('dc.fecha_emision', '>=', $fechaInicial);
            })
            ->when($request->input('fechaFinal'), function ($query, $fechaFinal) {
                return $query->whereDate('dc.fecha_emision', '<=', $fechaFinal);
            })
            ->groupByRaw('a.nombre')
            ->take(5)->get();
    }
    public function getCompras(Request $request)
    {
        $rango = new CarbonPeriod($request->fechaInicial, $request->fechaFinal);
        $fechas = array();
        $data = array();
        foreach ($rango as $key => $value) {
            $consulta = DB::table('documento_compra as dc')
                ->join('detalle_documento_compra as dcv', 'dcv.documento_compra_id', '=', 'dc.id')
                ->whereDate('dc.created_at', $value->format('Y-m-d'))
                ->select(DB::raw('sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('date(dc.created_at)');
            array_push($fechas, $value->format('Y-m-d'));
            array_push($data, $consulta->count() == 0 ? 0 : $consulta->first()->total);
        }
        return array("fechas" => $fechas, "data" => $data);
    }
    public function pdfVentas(Request $request)
    {
        // Log::info($request);
        $empresa = EmpresaPersonal::findOrFail(1);
        $datos = array();
        $total = 0;
        $rango = new CarbonPeriod($request->fechaInicial, $request->fechaFinal);
        foreach ($rango as $key => $value) {
            $consulta = DB::table('documento_venta as dv')
                ->join('detalle_documento_venta as dcv', 'dcv.documento_venta_id', '=', 'dv.id')
                ->whereDate('dv.fecha_registro', $value->format('Y-m-d'))
                ->select(DB::raw('sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('date(dv.fecha_registro)')
                ->when($request->input('estado'), function ($query, $estado) {
                    return $query->where('dv.estado_documento', $estado);
                });
            $usuarios = DB::table('documento_venta as dv')
                ->join('users as u', 'u.id', '=', 'dv.user_id')
                ->whereDate('dv.fecha_registro', $value->format('Y-m-d'))
                ->select('u.email')
                ->groupByRaw('u.email')
                ->when($request->input('estado'), function ($query, $estado) {
                    return $query->where('dv.estado_documento', $estado);
                })->get();
            $productos = DB::table('documento_venta as dv')
                ->join('detalle_documento_venta as dcv', 'dcv.documento_venta_id', '=', 'dv.id')
                ->join('producto as p', 'p.id', '=', 'dcv.producto_id')
                ->whereDate('dv.fecha_registro', $value->format('Y-m-d'))
                ->select(DB::raw('p.nombre,sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('p.nombre')
                ->when($request->input('estado'), function ($query, $estado) {
                    return $query->where('dv.estado_documento', $estado);
                })->get();
            $data = $consulta->count() == 0 ? 0 : $consulta->first()->total;
            $total += $data;
            array_push($datos, array("usuarios" => $usuarios, "fecha" => $value->format('Y-m-d'), "data" => $data, "productos" => $productos));
        }
        $pdf = PDF::loadView('reportes.pdf.pdfVentas', compact('empresa', 'datos', 'request', 'total'));
        return $pdf->stream();
    }
    public function pdfCompras(Request $request)
    {
        $empresa = EmpresaPersonal::findOrFail(1);
        $datos = array();
        $total = 0;
        $rango = new CarbonPeriod($request->fechaInicial, $request->fechaFinal);
        foreach ($rango as $key => $value) {

            $consulta = DB::table('documento_compra as dv')
                ->join('detalle_documento_compra as dcv', 'dcv.documento_compra_id', '=', 'dv.id')
                ->whereDate('dv.fecha_emision', $value->format('Y-m-d'))
                ->select(DB::raw('sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('date(dv.fecha_emision)');
            $proveedores = DB::table('documento_compra as dv')
                ->join('proveedor as p', 'p.id', '=', 'dv.proveedor_id')
                ->whereDate('dv.fecha_emision', $value->format('Y-m-d'))
                ->select('p.id')
                ->groupByRaw('p.id')->get();
            $nombres = array();
            foreach ($proveedores as $key => $v) {
                $persona = Proveedor::findOrFail($v->id)->persona;
                array_push($nombres, array("nombres" => $persona->personaDni ? $persona->personaDni->nombres_apellidos() : $persona->personaRuc->nombre_comercial));
            }
            $insumos = DB::table('documento_compra as dv')
                ->join('detalle_documento_compra as dcv', 'dcv.documento_compra_id', '=', 'dv.id')
                ->join('insumo as i', 'i.id', '=', 'dcv.insumo_id')
                ->whereDate('dv.fecha_emision', $value->format('Y-m-d'))
                ->select(DB::raw('i.nombre,sum(dcv.precio*dcv.cantidad) as total'))
                ->groupByRaw('i.nombre')->get();
            $data = $consulta->count() == 0 ? 0 : $consulta->first()->total;
            $total += $data;
            array_push($datos, array("proveedores" => $nombres, "fecha" => $value->format('Y-m-d'), "data" => $data, "insumos" => $insumos));
        }
        $pdf = PDF::loadView('reportes.pdf.pdfCompras', compact('empresa', 'datos', 'request', 'total'));
        return $pdf->stream();
    }
    public function pdfProductos(Request $request)
    {
        $empresa = EmpresaPersonal::findOrFail(1);
        $datos=DB::table('documento_venta as dv')
            ->join('detalle_documento_venta as dcv', 'dcv.documento_venta_id', '=', 'dv.id')
            ->join('producto as p', 'p.id', '=', 'dcv.producto_id')
            ->select(DB::raw('p.nombre,sum(dcv.cantidad) as cuenta'))
            ->when($request->input('fechaInicial'), function ($query, $fechaInicial) {
                return $query->whereDate('dv.fecha_registro', '>=', $fechaInicial);
            })
            ->when($request->input('fechaFinal'), function ($query, $fechaFinal) {
                return $query->whereDate('dv.fecha_registro', '<=', $fechaFinal);
            })
            ->groupByRaw('p.nombre')->get();
        $pdf = PDF::loadView('reportes.pdf.pdfProductos', compact('empresa', 'datos','request'));
        return $pdf->stream();
    }
    public function pdfAlmacen(Request $request)
    {
        $empresa = EmpresaPersonal::findOrFail(1);
        $datos=DB::table('documento_compra as dc')
            ->join('detalle_documento_compra as ddc', 'ddc.documento_compra_id', '=', 'dc.id')
            ->join('almacen as a', 'a.id', '=', 'dc.almacen_id')
            ->select(DB::raw('a.nombre,sum(ddc.cantidad) as cuenta'))
            ->when($request->input('fechaInicial'), function ($query, $fechaInicial) {
                return $query->whereDate('dc.fecha_emision', '>=', $fechaInicial);
            })
            ->when($request->input('fechaFinal'), function ($query, $fechaFinal) {
                return $query->whereDate('dc.fecha_emision', '<=', $fechaFinal);
            })
            ->groupByRaw('a.nombre')
            ->get();
        $pdf = PDF::loadView('reportes.pdf.pdfAlmacen', compact('empresa', 'datos','request'));
        return $pdf->stream();
    }
}
