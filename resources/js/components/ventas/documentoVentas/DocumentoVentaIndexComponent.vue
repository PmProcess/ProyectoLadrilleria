<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Documentos de Ventas</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Documentos de Ventas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Inicio</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-right mb-2">
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-agregar"
                                        @click="goCreate"
                                    >
                                        <i
                                            class="fa fa-plus"
                                            aria-hidden="true"
                                        ></i>
                                        Agregar Documento de venta
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table
                                            id="tableDocumentosVentas"
                                            class="
                                                table
                                                table-striped
                                                table-bordered
                                                table-hover
                                            "
                                            style="width: 100%"
                                        >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tipo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import "datatables.net-bs4";
import "datatables.net-buttons-bs4";
export default {
    data() {
        return {
            table:null
        };
    },
    mounted() {
        this.datosInicializado()
    },
    methods: {
        datosInicializado: function () {
            this.table = $("#tableDocumentos").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("documentoVentas.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                    },
                    {
                        data: null,
                        className: "text-center",
                        render:function(data){
                            if(data.tipo_documento_id==1)
                            {

                                return data.cliente.persona.tipoPersona.apellidos+" "+data.cliente.persona.tipoPersona.nombres;
                            }
                            return data.cliente.persona.tipoPersona.nombre_comercial;
                        }
                    },
                    {
                        data:null,
                        className:"text-center",
                        render:function(data){
                            return data.tipo_documento.tipo;
                        }
                    },
                    {
                        data:null,
                        className:"text-center",
                        render:function(data){
                            return data.tipo_pago
                        }
                    }
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return (
                                "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-danger  btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                                "<li><a class='dropdown-item btn-edit' href='#' title='Modificar' ><b><i class='fa fa-edit'></i>Editar</a></b></li>" +
                                "<li><a class='dropdown-item btn-delete'  title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                                "</ul></div>"
                            );
                            // return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown button</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div></div>';
                        },
                    },
                ],
            });
        },
        goCreate:function()
        {
            window.location.href=route('documentoVenta.create');
        }
    },
};
</script>
