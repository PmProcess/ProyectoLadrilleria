<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documento de Venta</title>
</head>
<style>
    html {
        /* margin: 0px !important; */
        margin: 25px;
    }

    body {
        font-size: 6pt;
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
    .padre{
        width:100%;

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
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:60%">
                    @if ($opcion->imagen->show)
                        @if ($empresa->nombre_imagen)
                            <img src="{{ base_path() . '/storage/app/' . $empresa->url_imagen }}"
                                style="height: 100px;width:100%">
                        @else
                            <img src="{{ public_path() . '/img/default.png' }}" style="height: 100px;width:100%">
                        @endif
                    @endif
                </th>
            </tr>
            <tr>
                <th>
                    @if ($opcion->empresa->nombre->show)
                        <div class="text-uppercase text-center">{{ $empresa->nombre_comercial }}</div>
                    @endif
                </th>
            </tr>
            <tr>
                <th style="width:100%;">
                    @if ($opcion->empresa->direccion->show)
                        <div class=" font-weight-bold">
                            Direccion
                            <span class="font-weight-none">{{ $empresa->direccion }}<span>
                        </div>
                    @endif
                    @if ($opcion->empresa->phone->show)
                        <div class=" font-weight-bold">
                            Telefono:
                            <span class="font-weight-none">{{ $empresa->telefono }}</span>
                        </div>
                    @endif
                    @if ($opcion->empresa->email->show)
                        <div class=" font-weight-bold">
                            Email:
                            <span class="font-weight-none">{{ $empresa->correo }}</span>
                        </div>
                    @endif
                </th>
            </tr>
            <tr>
                <th>
                    <div class="padre">
                        <div class="cuadro-documento text-center"
                            style="border-color:{{ $opcion->cuadroDocumento->borderColor }}">
                            <div class="font-weight-light">
                                RUC {{ $empresa->ruc }}
                            </div>
                            <div style="background-color:{{ $opcion->cuadroDocumento->serie->backgroundColor }};
                        color:{{ $opcion->cuadroDocumento->serie->color }}">
                                {{ $documento->correlativo->numeracion->serie . '-' . $documento->correlativo->correlativo }}
                            </div>
                            <div class="font-weight-light">
                                {{ $documento->tipoDocumento->tipo }}
                            </div>
                        </div>
                    </div>

                </th>
            </tr>
        </thead>
    </table>
    <table style="width:100%;" class="mt-5">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="font-weight-bold text-uppercase ">
                        Nombre:

                    </div>
                </td>
                <td>
                    <span
                        class="font-weight-none">{{ $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->nombres_apellidos() : $documento->cliente->persona->personaRuc->nombre_comercial }}</span>
                </td>
            </tr>
            <tr>
                <td style="width:50%;">
                    <div class=" font-weight-bold m-0 text-uppercase ">
                        N°Documento:

                    </div>
                </td>
                <td>
                    <span
                        class="font-weight-none">{{ $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->dni : $documento->cliente->persona->personaRuc->ruc }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class=" font-weight-bold text-uppercase ">
                        Fecha Emision:

                    </div>
                </td>
                <td>
                    <span class="font-weight-none">{{ $documento->created_at->format('Y-m-d h:i') }}</span>
                </td>
            </tr>
            <tr>
                <td style="width:50%;">
                    @if ($opcion->cliente->direccion->show)
                        <div class=" font-weight-bold text-uppercase ">
                            Direccion:

                        </div>
                    @endif
                </td>
                <td>
                    @if ($opcion->cliente->direccion->show)
                        <span class="font-weight-none ">{{ $documento->cliente->persona->direccion }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    @if ($opcion->cliente->tipoMoneda->show)
                        <div class=" font-weight-bold text-uppercase ">
                            Tipo de Moneda:
                        </div>
                    @endif
                </td>
                <td>
                    @if ($opcion->cliente->tipoMoneda->show)
                        <span class="font-weight-none">SOLES</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    @if ($opcion->cliente->formaPago->show)
                        <div class=" font-weight-bold text-uppercase ">
                            Forma de pago:
                        </div>
                    @endif
                </td>
                <td>
                    @if ($opcion->cliente->formaPago->show)
                        <span class="font-weight-none">CONTADO</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width:50%;">
                </td>
            </tr>
        </tbody>
    </table>
    <div style="position:relative;width:100%;">
        <table style="width:100%;" cellspacing="0"
            class="table table-light mt-3 {{ $opcion->table->tipo == 'striped' ? 'table-striped' : '' }} {{ $opcion->table->border ? 'table-bordered' : '' }}">
            <thead class=""
                style="background-color:{{ $opcion->table->header->backgroundColor }};color:{{ $opcion->table->header->color }}">
                <tr>
                    <th style="width:10%;text-align:center;border:solid {{ $opcion->table->header->borderColor }};
                    {{ $opcion->table->border ? 'border-width:0.3px 0.3px 0.3px 0.3px' : 'border-width:0.3px 0px 0.3px 0px' }}">
                        Cant</th>
                    <th style="width:20%;text-align:center;border:solid {{ $opcion->table->header->borderColor }};
                    {{ $opcion->table->border ? 'border-width:0.3px 0.3px 0.3px 0.3px' : 'border-width:0.3px 0px 0.3px 0px' }}">
                        Codigo</th>
                    <th style="width:40%;text-align:center;border:solid {{ $opcion->table->header->borderColor }};
                    {{ $opcion->table->border ? 'border-width:0.3px 0.3px 0.3px 0.3px' : 'border-width:0.3px 0px 0.3px 0px' }}">
                        Descripcion</th>
                    <th style="width:15%;text-align:center;border:solid {{ $opcion->table->header->borderColor }};
                    {{ $opcion->table->border ? 'border-width:0.3px 0.3px 0.3px 0.3px' : 'border-width:0.3px 0px 0.3px 0px' }}">
                        P.Unitario</th>
                    <th style="width:15%;border:solid {{ $opcion->table->header->borderColor }};
                    {{ $opcion->table->border ? 'border-width:0.3px 0.3px 0.3px 0.3px' : 'border-width:0.3px 0px 0.3px 0px' }}"
                        class="text-right">
                        Importe</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($documento->detalle as $item)
                    <tr>
                        <th class="text-center">{{ $item->cantidad }}</th>
                        <th class="text-center">{{ $item->producto->codigo }}</th>
                        <th>{{ $item->producto->nombre }}</th>
                        <th>{{ $item->producto->precio_venta }}</th>
                        <th class="text-right">
                            {{ number_format($item->producto->precio_venta * $item->cantidad, 2, '.', ' ') }}</th>
                    </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr class="">
                    <th class="text-center" colspan="4">
                        TOTAL
                    </th>
                    <th class="text-right">
                        {{ $documento->total }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="qr">
        @if ($documento->url_qr)
            <img src="{{ base_path() . '/storage/app/' . $documento->url_qr }}">
        @endif
        @if ($documento->hash)
            <p class="m-0 p-0">Código Hash: {{ $documento->hash }}</p>
        @endif
    </div>

</body>

</html>
