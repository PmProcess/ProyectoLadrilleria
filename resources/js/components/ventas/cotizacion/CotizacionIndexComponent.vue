<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Cotizaciones</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Cotizaciones</a>
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
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table
                                            id="tableCotizacion"
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
                                                    <th>Fecha</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th>Estado</th>
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
    props: [ "error", "mensaje"],
    data() {
        return {
            table: null,
            documento_venta_id: "",
        };
    },
    mounted() {
        var $this = this;
        this.datosInicializado();
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
                            "cotizacion.destroy",
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
            this.table = $("#tableCotizacion").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("cotizacion.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: null,
                        className: "text-center",
                        render: function(data)
                        {
                            return data.created_at;
                        }
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            console.log(data)
                                return (
                                    data.cliente.persona.tipo_persona.nombres
                                );
                        },
                    },
                    {
                        data:'total',
                        className:"text-center"
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.estado_cotizacion;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            let opciones = "";

                            if (data.estado_cotizacion == "PENDIENTE") {
                               opciones +=
                                    "<li><a class='dropdown-item btn-documento'  title='Enviar'><b><i class='fa fa-list'></i>Documento Venta</a></b></li>";
                                opciones +=
                                    "<li><a class='dropdown-item btn-delete'  title='Eliminar'><b><i class='fa fa-trash'></i>Eliminar</a></b></li>";
                                return (
                                "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-danger  btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                                opciones +
                                "</ul></div>");
                               // return "<button class='btn btn-warning'>Documento Venta</button><button class='btn btn-danger'>Eliminar </button>"
                            }
                            return "";
                            
                        

                            
                        },
                    },
                ],
            });
        },
        goCreate: function () {
            window.location.href = route("cotizacion.create");
        },
    },
};
</script>
<style>
.swal2-container {
    z-index: 4000;
}
/* label.required::before{
    content: " * ";
    color: #f35731;
} */
</style>
