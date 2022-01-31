<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Almacenes</title>
</head>
<style>
    html {
        /* margin: 0px !important; */
        margin: 25px;
    }

    body {
        /* font-size: 6pt; */
        padding: 0px;
        margin: 0px;
        font-family: Arial, Helvetica, sans-serif;
        color: black;
    }

    /* .small {
        font-size: 80%;
    } */
    .font-weight-bold {
        font-weight: 700 !important;
    }

    .font-weight-none {
        font-weight: none !important
    }

    .cuadro-documento {
        border: solid;
        width: 100px;
        height: 40px;
        margin: 0 auto;

    }

    .padre {
        width: 100%;

    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .table-light,
    .table-light>th,
    .table-light>td {
        background-color: #fdfdfe;
    }

    .table th,
    .table td {
        vertical-align: top;
    }

    .table thead th {
        vertical-align: bottom;
    }

    .table .thead-light th {
        color: #495057;
        background-color: #e9ecef;
    }

    .qr {
        position: relative;
        width: 100%;
        align-content: center;
        text-align: center;
        margin-top: 10px;
    }

</style>

<body>
    <h3 style="text-transform: uppercase;text-align:center">Reporte de Top Almacenes mas usados</h3>
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:25%">
                    @if ($empresa->nombre_imagen)
                        <img src="{{ base_path() . '/storage/app/' . $empresa->url_imagen }}"
                            style="height: 100px;width:100%">
                    @else
                        <img src="{{ public_path() . '/img/default.png' }}" style="height: 100px;width:100%">
                    @endif
                </th>
                <th style="width:50%;padding-left:4px">
                    <div class="text-uppercase  text-center">{{ $empresa->nombre_comercial }}</div>
                    <div class="small font-weight-bold">
                        Direccion
                        <span class="font-weight-none">{{ $empresa->direccion }}<span>
                    </div>
                    <div class="small font-weight-bold">
                        Telefono:
                        <span class="font-weight-none">{{ $empresa->telefono }}</span>
                    </div>
                    <div class="small font-weight-bold">
                        Email:
                        <span class="font-weight-none">{{ $empresa->correo }}</span>
                    </div>
                </th>
            </tr>
        </thead>
    </table>
    <table style="width:100%;" class="mt-5">
        <thead>
            <tr>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width:50%">
                    <div class="small font-weight-bold">
                        Rango de Fechas:
                        <span
                            class="font-weight-none">{{ $request->fechaInicial . ' - ' . $request->fechaFinal }}</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%;margin-top:10px;" cellspacing=0>

        <thead style="background:#f35731;color:white;">
            <tr>
                <th
                    style="width:25%;padding-top: 10px;padding-bottom:10px;border-top-left-radius: 10px;border-bottom-left-radius: 10px;">
                    Almacen</th>
                <th
                    style="width:25%;padding-top: 10px;padding-bottom:10px;border-bottom-right-radius: 10px;border-top-right-radius: 10px;">
                    Cant Almacenada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $fila)
                <tr>
                    <th>{{ $fila->nombre }}</th>
                    <th>{{ number_format($fila->cuenta, 2) }}</th>
            @endforeach
        </tbody>
    </table>
</body>

</html>
