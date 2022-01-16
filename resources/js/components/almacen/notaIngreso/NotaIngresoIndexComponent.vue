<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Nota de Ingreso</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Nota de Ingreso</a>
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
                                        Agregar Nota de Ingresos
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table
                                            id="tableNotaIngreso"
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
                                                    <th>Codigo</th>
                                                    <th>Fecha</th>
                                                    <th>Almacen</th>
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
import "sweetalert2/dist/sweetalert2.min.css";
import "datatables.net-bs4";
import "datatables.net-buttons-bs4";
export default {
    props: ["formaspagos", "error", "mensaje"],
    data() {
        return {
            table: null,
        };
    },
    mounted() {
        var $this = this;

        this.datosInicializado();
        $(document).on("click", ".btn-edit", function (e) {
            window.location.href = route(
                "notaIngreso.edit",
                $this.table.row($(this).closest("tr")).data().id
            );
        });
        $(document).on("click", ".btn-delete", function (e) {
            $this.$swal
                .fire({
                    title: "Estas Seguro?",
                    text: "Tu deseas eliminar este registro",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si eliminar",
                    cancelButtonText: "Cancelar",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = route(
                            "notaIngreso.destroy",
                            $this.table.row($(this).closest("tr")).data().id
                        );
                    }
                });
        });

        //-------Error
        if (this.error != null) {
            this.$swal.fire({
                icon: "error",
                title: "Oops...",
                text: this.error,
            });
        }
        if (this.mensaje != null) {
            this.$swal.fire({
                icon: "successs",
                title: "Mensaje de Registro",
                text: this.mensaje,
            });
        }
    },
    methods: {
        datosInicializado: function () {
            this.table = $("#tableNotaIngreso").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("notaIngreso.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                    },
                    {
                        data: "codigo",
                        className: "text-center"
                    },
                    {
                        data: null,
                        render: function (data) {
                            let fecha = new Date(data.fecha_emision);
                            return (
                                fecha.toISOString().split("T")[0] +
                                " " +
                                fecha.getHours() +
                                ":" +
                                fecha.getMinutes()
                            );
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.almacen.nombre;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            let opciones = "";
                            opciones +=
                                "<li><a class='dropdown-item btn-edit'  title='Editar Documento'><b><i class='fa fa-pencil'></i>Editar</a></b></li>";
                            opciones +=
                                "<li><a class='dropdown-item btn-delete'  title='Eliminar Documento'><b><i class='fa fa-trash'></i>Eliminar</i></a></b></li>";
                            return (
                                "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-danger  btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                                opciones +
                                "</ul></div>"
                            );
                        },
                    },
                ],
            });
        },
        goCreate: function () {
            window.location.href = route("notaIngreso.create");
        },
    },
};
</script>
<style>
.swal2-container {
    z-index: 4000;
}
</style>
