<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\TipoDocumento;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TipoDocumentoController extends Controller
{
    public function index(){
        // $tiposDocumentos =TipoDocumento::get();
        return view('configuracion.tipoDocumento.index');
    }
    public function getList(){
        $tiposDocumentos= TipoDocumento::get();
        return DataTables::of($tiposDocumentos)->toJson();
    }
    public function vistaPrevia($tipo)
    {
        if($tipo=="Boleta de Venta")
        {
            $pdf=PDF::loadView('pdf.tiposDocumento.boleta');
        }
        elseif($tipo=="Factura de Venta")
        {
            $pdf=PDF::loadView('pdf.tiposDocumento.factura');
        }

        return $pdf->stream();
    }
    public function update(Request $request, $id){
        DB::beginTransaction();
        try{
            TipoDocumento::findOrFail($id)->update($request);
            DB::commit();
            return array('success' =>true,"mensaje"=>"Exito");
        }
        catch(Exception $e){
            Log::info($e);
            DB::rollback();
            return array('success'=>false,"mensaje"=>$e->getMessage());
        }
    }
}
