<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Mantenimiento\EmpresaPersonal;
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
        $file = database_path("data/TipoDocumento/tipodocumento.json");
        $json = file_get_contents($file);
        // $arreglo = json_decode($json);
        return view('configuracion.tipoDocumento.index',compact('json'));
    }
    public function formatoPdf(){
        $file = database_path("data/TipoDocumento/tipodocumento.json");
        $json = file_get_contents($file);
        return $json;
    }
    public function getList(){
        $tiposDocumentos= TipoDocumento::where('id','!=','3')->get();
        return DataTables::of($tiposDocumentos)->toJson();
    }
    public function vistaPreviaPdf($arreglo,$tipo)
    {
        $data = json_decode($arreglo);
        $empresa=EmpresaPersonal::findOrFail(1);
        if($tipo=="Boleta de Venta")
        {
            $documento=$data[0]->Boleta;
            $pdf=PDF::loadView('pdf.tiposDocumento.boleta',compact('documento','empresa'));
        }
        elseif($tipo=="Factura de Venta")
        {
            $documento=$data[0]->Factura;
            $pdf=PDF::loadView('pdf.tiposDocumento.factura',compact('documento','empresa'));
        }
        elseif($tipo=="Recibo de Venta")
        {
            $documento=$data[0]->Recibo;
            $pdf=PDF::loadView('pdf.tiposDocumento.recibo',compact('documento','empresa'));
        }

        return $pdf->stream();
    }
    public function updatePdf($arreglo,$tipo)
    {
        try {
            $file = database_path("data/TipoDocumento/tipodocumento.json");
            $json = file_get_contents($file);
            $data = json_decode($json);

            $dataArreglo = json_decode($arreglo);

            $fh = fopen($file,'r+');
            if($tipo=="Boleta de Venta")
            {
                $data[0]->Boleta=$dataArreglo[0]->Boleta;
            }
            elseif($tipo=="Factura de Venta"){
                $data[0]->Factura=$dataArreglo[0]->Factura;
            }
            elseif($tipo=="Recibo de Venta"){
                $data[0]->Recibo=$dataArreglo[0]->Recibo;
            }
            file_put_contents(database_path("data/TipoDocumento/tipodocumento.json"), json_encode($data));

            fclose($fh);
            return array("success"=>true,"mensaje"=>"Registro con Exito");
        } catch (Exception $e) {
            Log::info($e);
            return array("success"=>false,"mensaje"=>"Ocurrio un Error");
        }
    }
    public function vistaPrevia($tipo)
    {
        $file = database_path("data/TipoDocumento/tipodocumento.json");
        $json = file_get_contents($file);
        $data = json_decode($json);
        $empresa=EmpresaPersonal::findOrFail(1);
        if($tipo=="Boleta de Venta")
        {
            $documento=$data[0]->Boleta;
            $pdf=PDF::loadView('pdf.tiposDocumento.boleta',compact('documento','empresa'));
        }
        elseif($tipo=="Factura de Venta")
        {
            $documento=$data[0]->Factura;
            $pdf=PDF::loadView('pdf.tiposDocumento.factura',compact('documento','empresa'));
        }
        elseif($tipo=="Recibo de Venta")
        {
            $documento=$data[0]->Recibo;
            $pdf=PDF::loadView('pdf.tiposDocumento.recibo',compact('documento','empresa'));
        }

        return $pdf->stream();
    }
    public function update(Request $request, $id){
        DB::beginTransaction();
        try{
            TipoDocumento::findOrFail($id)->update($request->all());
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
