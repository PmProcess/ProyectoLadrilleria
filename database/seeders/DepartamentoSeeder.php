<?php

namespace Database\Seeders;

use App\Models\Ubigeo\Departamento;
use App\Models\Ubigeo\Distrito;
use App\Models\Ubigeo\Provincia;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //departamentos 25
        //distrito 1856
        //provincia 196
        $file = database_path("data/ubigeo/ubigeo.json");
        $json = file_get_contents($file);
        $data = json_decode($json);

        $departamentos = [];
        $provincias = [];
        $distritos = [];
        foreach ($data as $obj) {
            if ($obj->Provincia == "" && $obj->Distrito == "") {
                $departamentos[] = [
                    "nombre" => $obj->Departamento,
                    "ubigeo" => $obj->IdUbigeo
                ];
            }
        }
        $arrayDepartamentos = array_chunk($departamentos, 25);
        foreach ($arrayDepartamentos as $valor) {
            Departamento::insert($valor);
        }
        //--------------Provincias
        foreach ($data as $obj) {
            if ($obj->Provincia != "" && $obj->Distrito == "") {
                $departamento = Departamento::where('nombre', $obj->Departamento)->first();
                $provincias[] =  [
                    "departamento_id" => $departamento->id,
                    "nombre" => $obj->Provincia,
                    "ubigeo" => $obj->IdUbigeo
                ];
            }
        }
        $arrayProvincias = array_chunk($provincias, 196);
        foreach ($arrayProvincias as $valor) {
            Provincia::insert($valor);
        }
        //---------------Distrito
        foreach ($data as $obj) {
            if ($obj->Provincia != "" && $obj->Distrito != "") {
                $provincia = Provincia::where('nombre', $obj->Provincia)->first();
                $distritos[] =  [
                    "provincia_id" => $provincia->id,
                    "nombre" => $obj->Distrito,
                    "ubigeo" => $obj->IdUbigeo
                ];
            }
        }
        $arrayDistritos = array_chunk($distritos, 1856);
        foreach ($arrayDistritos as $valor) {
            Distrito::insert($valor);
        }
    }
}
