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
        <div
            class="modal fade"
            id="modalEdit"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Editar Tipo de Documento
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tipo</label>
                            <input
                                type="text"
                                disabled
                                class="form-control"
                                v-model="tipo"
                            />
                        </div>
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <textarea
                                cols="30"
                                rows="3"
                                v-model="descripcion"
                                class="form-control"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Cerrar
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editar"
                        >
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <factura-index-component
            :json="json"
            ref="facturaIndexComponent"
        ></factura-index-component>
        <boleta-index-component
            :json="json"
            ref="boletaIndexComponent"
        ></boleta-index-component>
    </div>
</template>
<script>
import "datatables.net-bs4";
import "datatables.net-buttons-bs4";
import FacturaIndexComponent from "./Tipos/FacturaIndexComponent.vue";
import BoletaIndexComponent from "./Tipos/BoletaIndexComponent.vue";
export default {
    components: { FacturaIndexComponent, BoletaIndexComponent },
    props: ["json"],
    data() {
        return {
            preview: false,
            previewPdf: false,
            table: null,
            src: "",
            srcModify: "",
            tipo: "",
            descripcion: "",
            id: "",
        };
    },
    created() {
        var $this = this;
    },
    mounted() {
        this.inicializarDatatables();
        var $this = this;
        $(document).on("click", ".btn-edit", function (e) {
            var dato = $this.table.row($(this).closest("tr")).data();
            $this.tipo = dato.tipo;
            $this.descripcion = dato.descripcion;
            $this.id = dato.id;
            $("#modalEdit").modal("show");
        });
        $(document).on("click", ".btn-show", function (e) {
            var dato = $this.table.row($(this).closest("tr")).data();
            $this.src = route("tipoDocumento.vistaPrevia", dato.tipo);
            $this.preview = true;
        });
        $(document).on("click", ".btn-edit-pdf", function (e) {
            var dato = $this.table.row($(this).closest("tr")).data();
            if (dato.tipo == "Boleta de Venta") {
                $this.$refs.boletaIndexComponent.setTipo(dato.tipo);
                $this.$refs.boletaIndexComponent.openModal();
            } else if (dato.tipo == "Factura de Venta") {
                $this.$refs.facturaIndexComponent.setTipo(dato.tipo);
                $this.$refs.facturaIndexComponent.openModal();
            }
        });
    },
    methods: {
        editar: function () {
            var $this = this;
            var data = new FormData();
            data.append("tipo", $this.tipo);
            data.append("descripcion", $this.descripcion);
            axios
                .post(route("tipoDocumento.update", $this.id), data)
                .then((value) => {
                    $this.table.ajax.reload();
                    $("#modalEdit").modal("hide");
                });
        },
        onLoad: function (frame) {},
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
                                "<li><a class='dropdown-item btn-edit-pdf' href='#' title='Modificar PDF' ><b><i class='fa fa-file-pdf-o'></i>Editar Pdf</a></b></li>" +
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
<style>
@media (min-width: 768px) {
    .modal-xl {
        width: 90%;
        max-width: 1200px;
    }
}
</style>
