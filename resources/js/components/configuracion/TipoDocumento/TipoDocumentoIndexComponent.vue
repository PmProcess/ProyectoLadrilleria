<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Tipos de Documentos</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Tipos de Documentos</a>
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
                            <div :class="preview ? 'col-md-7' : 'col-md-12'">
                                <table
                                    id="tableTiposDocumentos"
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
                                            <th>Descripcion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div
                                class="col-md-5"
                                v-if="preview"
                                style="height: 400px"
                            >
                                <vue-iframe :src="src" @load="onLoad" />
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
            preview: false,
            table:null,
            src: "",
        };
    },
    mounted() {
        this.inicializarDatatables();
        var $this=this;
        $(document).on('click','.btn-edit',function(e) {
            console.log($this.table.row($(this).closest('tr')).data())
        })
        $(document).on('click','.btn-show',function(e) {
            var dato=$this.table.row($(this).closest('tr')).data();
            $this.src=route('tipoDocumento.vistaPrevia',dato.tipo)
            $this.preview=!$this.preview
        })
    },
    methods: {
        onLoad: function (frame) {

        },
        inicializarDatatables: function () {
            this.table = $("#tableTiposDocumentos").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("tipoDocumento.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                        width: "10%",
                    },
                    {
                        data: "tipo",
                        className: "text-center",
                        width: "30%",
                    },
                    {
                        data: "descripcion",
                        className: "text-center",
                        width: "50%",
                    },
                    {
                        data: null,
                        width: "10%",
                        className: "text-center",
                        render: function (data) {
                            return (
                                "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-danger  btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                                "<li><a class='dropdown-item btn-show' href='#' title='ver' ><b><i class='fa fa-eye'></i>Ver</a></b></li>" +
                                "<li><a class='dropdown-item btn-edit' href='#' title='Modificar' ><b><i class='fa fa-edit'></i>Editar</a></b></li>" +
                                "</ul></div>"
                            );
                            // return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown button</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div></div>';
                        },
                    },
                ],
            });
        },
    },
};
</script>
