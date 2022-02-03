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
                            <div class="form-group col-md-10">
                                <!-- <button class="btn btn-primary" @click="reiniciar">Reiniciar</button> -->
                                <h4>Tiempo:{{ tiempo }} milliseconds</h4>
                            </div>
                            <div class="form-group col-md-2 mt-4">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-agregar"
                                    @click="goCreate"
                                >
                                    <i
                                        class="fa fa-plus"
                                        aria-hidden="true"
                                    ></i>
                                    Agregar
                                </button>
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
                                                    <th>Fecha</th>
                                                    <th>Cliente</th>
                                                    <th>Tipo Doc</th>
                                                    <!-- <th>Tipo Pago</th> -->
                                                    <th>Serie</th>
                                                    <th>Total</th>
                                                    <th>Deuda</th>
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
        <div
            class="modal fade"
            id="modalListPago"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Pagos
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
                        <div style="float: right" v-if="montoDeuda != 0">
                            <button
                                class="btn btn-primary"
                                @click="modalPago()"
                            >
                                <i class="fa fa-plus"></i> Nuevo
                            </button>
                        </div>
                        <table
                            id="tablePagos"
                            class="
                                table table-striped table-bordered table-hover
                            "
                            style="width: 100%"
                        >
                            <thead>
                                <tr>
                                    <th>T.Pago</th>
                                    <th>Efectivo</th>
                                    <th>Transf</th>
                                    <th>Fecha</th>
                                    <th>Img</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="button" class="btn btn-primary">
                            Save changes
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="modalPago"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="display: inherit !important">
                    <div style="float: right">
                        <button
                            type="button"
                            class="close m-3"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div
                        class="modal-header text-center"
                        style="display: inherit !important"
                    >
                        <h4
                            class="modal-title text-center text-uppercase"
                            id="exampleModalLabel"
                        >
                            Registrar Pago
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="" class="required"
                                            >Forma de pago</label
                                        >
                                        <v-select
                                            label="tipo"
                                            :options="formaspagos"
                                            v-model="formaPago"
                                            v-on:input="changeFormaPago"
                                        ></v-select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="required"
                                            >Efectivo</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="efectivo"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="required"
                                            >Transferencia</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            :disabled="
                                                formaPago.tipo == 'EFECTIVO'
                                            "
                                            v-model="transferencia"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label id="logo_label"
                                                    >Pago:</label
                                                >
                                                <div class="custom-file">
                                                    <input
                                                        id="logo"
                                                        type="file"
                                                        name="logo"
                                                        v-on:change="
                                                            seleccionarimage
                                                        "
                                                        class="
                                                            custom-file-input
                                                        "
                                                        accept="image/*"
                                                    />
                                                    <label
                                                        for="logo"
                                                        id="logo_txt"
                                                        name="logo_txt"
                                                        class="
                                                            custom-file-label
                                                            selected
                                                        "
                                                        >Seleccionar</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-7">
                                                <div
                                                    class="
                                                        row
                                                        justify-content-end
                                                    "
                                                >
                                                    <a
                                                        href="javascript:void(0);"
                                                        id="limpiar_logo"
                                                        v-on:click="limpiar"
                                                    >
                                                        <span
                                                            class="
                                                                badge
                                                                badge-danger
                                                            "
                                                            >x</span
                                                        >
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-7">
                                                <p>
                                                    <img
                                                        class="
                                                            logo
                                                            rounded
                                                            img-fluid
                                                        "
                                                        alt=""
                                                    />
                                                    <input
                                                        id="url_logo"
                                                        name="url_logo"
                                                        type="hidden"
                                                        value=""
                                                    />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            @click="storePago()"
                        >
                            Guardar
                        </button>
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
    props: ["formaspagos", "error", "mensaje", "tiempophp"],
    data() {
        return {
            table: null,
            tablePagos: null,
            formaPago: {
                id: 3,
                tipo: "EFECTIVO",
            },
            efectivo: 0,
            transferencia: 0,
            file: "",
            documento_venta_id: "",
            montoDeuda: -1,
            tiempoBackend: 0,
            tiempoPagina: 0,
            tiempo: 0,
            intervalo: null,
            hours: 0,
            minutes: 0,
            seconds: 0,
            milliseconds: 0,
        };
    },
    mounted() {
        var $this = this;
        this.tiempoBackend = this.tiempophp;
        $(".logo").attr(
            "src",
            window.location.origin + "/img/defaultmoney.jpg"
        );
        this.datosInicializado();

        // $this.updateTime(0, 0, 0, 0);

        // let start = performance.now();
        // window.addEventListener("unload", function () {
        //     $this.tiempoPagina=performance.now() - start
        //     console.log($this.tiempoPagina)
        //     console.log("dfasd")
        // });
        let tiempoInicio = new Date();
        let inicio = 1;
        $this.table.on("draw", function () {
            var timeElapsed = new Date().getTime() - tiempoInicio.getTime();
            if (inicio <= 2) {
                $this.tiempo = (
                    parseFloat($this.tiempoBackend) + parseFloat(timeElapsed)
                ).toFixed(2);
                inicio++;
            }

            //  clearInterval($this.intervalo);
        });
        window.addEventListener("load", function () {
            $this.table.on("search.dt", function () {
                // inicio="final"
                // var startTime = new Date(); // fetch current time
                // var timeElapsed = new Date().getTime() - startTime.getTime(); // calculate the time elapsed in milliseconds
                // // calculate hours
                // $this.hours = parseInt(timeElapsed / 1000 / 60 / 60);
                // // calculate minutes
                // $this.minutes = parseInt(timeElapsed / 1000 / 60);
                // if ($this.minutes > 60) $this.minutes %= 60;
                // // calculate seconds
                // $this.seconds = parseInt(timeElapsed / 1000);
                // if ($this.seconds > 60) $this.seconds %= 60;
                // // calculate milliseconds
                // $this.milliseconds = timeElapsed;
                // if ($this.milliseconds > 1000) $this.milliseconds %= 1000;
                // $this.tiempo += $this.milliseconds;
                // // set the stopwatch
                // // setStopwatch(hours, minutes, seconds, milliseconds);
                // $this.updateTime(0, 0, 0, 0);
            });
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
                            "documentoVenta.destroy",
                            $this.table.row($(this).closest("tr")).data().id
                        );
                    }
                });
        });
        $(document).on("click", ".btn-pagar", function (e) {
            let datos = $this.table.row($(this).closest("tr")).data();
            $this.tablePagos.clear().draw();
            datos.pagos.forEach((value, index, array) => {
                let pagoRow = {};
                $this.tablePagos.row.add(Object.assign(value, pagoRow)).draw();
            });
            $this.documento_venta_id = datos.id;
            $this.montoDeuda = parseFloat(datos.deuda);
            $("#modalListPago").modal("show");
        });
        $(document).on("click", ".btn-download", function (e) {
            toastr.warning("No existe Imagen con este registro");
        });
        $(document).on("click", ".btn-ticket", function (e) {
            let datos = $this.table.row($(this).closest("tr")).data();
            window.open(
                route("documentoVenta.ticket", datos.id),
                "myWindow",
                "width=900,height=600"
            );
        });
        $(document).on("click", ".btn-a4", function (e) {
            let datos = $this.table.row($(this).closest("tr")).data();
            window.open(
                route("documentoVenta.a4", datos.id),
                "myWindow",
                "width=900,height=600"
            );
        });
        $(document).on("click", ".btn-sunat", function (e) {
            let datos = $this.table.row($(this).closest("tr")).data();
            window.location.href = route("documentoVenta.sunat", datos.id);
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
        updateTime(prev_hours, prev_minutes, prev_seconds, prev_milliseconds) {
            var startTime = new Date(); // fetch current time
            let $this = this;
            $this.intervalo = setInterval(function () {
                var timeElapsed = new Date().getTime() - startTime.getTime(); // calculate the time elapsed in milliseconds

                // calculate hours
                $this.hours =
                    parseInt(timeElapsed / 1000 / 60 / 60) + prev_hours;

                // calculate minutes
                $this.minutes =
                    parseInt(timeElapsed / 1000 / 60) + prev_minutes;
                if ($this.minutes > 60) $this.minutes %= 60;

                // calculate seconds
                $this.seconds = parseInt(timeElapsed / 1000) + prev_seconds;
                if ($this.seconds > 60) $this.seconds %= 60;

                // calculate milliseconds
                $this.milliseconds = timeElapsed + prev_milliseconds;
                if ($this.milliseconds > 1000) $this.milliseconds %= 1000;
                $this.tiempo += $this.milliseconds;

                // set the stopwatch
                // setStopwatch(hours, minutes, seconds, milliseconds);
            }, 25); // update time in stopwatch after every 25ms
        },
        datosInicializado: function () {
            this.tablePagos = $("#tablePagos").DataTable({
                bPaginate: true,
                bLengthChange: true,
                // bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                searching: true,
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: null,
                        render: function (data) {
                            return data.forma_pago.tipo;
                        },
                    },
                    {
                        data: null,
                        render: function (data) {
                            return data.efectivo;
                        },
                    },
                    {
                        data: null,
                        render: function (data) {
                            return data.transferencia;
                        },
                    },
                    {
                        data: null,
                        render: function (data) {
                            let fecha = new Date(data.created_at);
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
                        render: function (data) {
                            return (
                                "<a class='btn btn-primary " +
                                (data.url_imagen == null
                                    ? "btn-download'"
                                    : "' href='" +
                                      route(
                                          "documentoVenta.pago.download",
                                          data.id
                                      ) +
                                      "'") +
                                " role='button'  title='descargar' style='color:white;'><i class='fa fa-download'></i> Descargar</a>"
                            );
                        },
                    },
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 4],
                        className: "text-center",
                    },
                    {
                        targets: [4],
                        width: "10%",
                    },
                    {
                        targets: [1, 2],
                        width: "20%",
                    },
                ],
            });
            this.table = $("#tableDocumentosVentas").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bInfo: true,
                searching: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("documentoVenta.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columns: [
                    {
                        data: "fecha_registro",
                        className: "text-center",
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            if (data.tipo_documento_id == 1) {
                                return (
                                    data.cliente.persona.tipo_persona
                                        .apellidos +
                                    " " +
                                    data.cliente.persona.tipo_persona.nombres
                                );
                            }
                            return data.cliente.persona.tipo_persona
                                .nombre_comercial;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.tipo_documento.tipo;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return (
                                data.correlativo.numeracion.serie +
                                "-" +
                                data.correlativo.correlativo
                            );
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.total;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.deuda;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.estado_documento;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            let opciones = "";
                            opciones +=
                                "<li><a class='dropdown-item btn-ticket'  title='Imprimir Ticket'><b><i class='fa fa-print'></i> Ticket</a></b></li>";
                            opciones +=
                                "<li><a class='dropdown-item btn-a4'  title='Imprimir A4'><b><i class='fa fa-print'></i> A4</a></b></li>";

                            if (data.estado_documento == "PENDIENTE") {
                                opciones +=
                                    "<li><a class='dropdown-item btn-pagar'  title='Pagar'><b><i class='fa fa-money'></i> Pagar</a></b></li>";
                                opciones +=
                                    "<li><a class='dropdown-item btn-delete'  title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>";
                            } else if (data.estado_documento == "PAGADO") {
                                opciones +=
                                    "<li><a class='dropdown-item btn-sunat'  title='Pagar'><b><i class='fa fa-send'></i> Sunat</a></b></li>";
                                opciones +=
                                    "<li><a class='dropdown-item btn-pagar'  title='Pagar'><b><i class='fa fa-money'></i> Pagar</a></b></li>";
                            } else if (data.estado_documento == "EXITO") {
                                opciones +=
                                    "<li><a class='dropdown-item btn-pagar'  title='Pagar'><b><i class='fa fa-money'></i> Pagar</a></b></li>";
                            } else if (data.estado_documento == "FALLO") {
                                opciones +=
                                    "<li><a class='dropdown-item btn-sunat'  title='Pagar'><b><i class='fa fa-send'></i> Sunat</a></b></li>";
                                opciones +=
                                    "<li><a class='dropdown-item btn-pagar'  title='Pagar'><b><i class='fa fa-money'></i> Pagar</a></b></li>";
                            }

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
            window.location.href = route("documentoVenta.create");
        },
        changeFormaPago: function () {
            if (this.formaPago.tipo == "EFECTIVO") {
                this.transferencia = 0;
            }
        },
        modalPago: function () {
            this.formaPago = {
                id: 3,
                tipo: "EFECTIVO",
            };
            this.efectivo = 0;
            this.transferencia = 0;
            this.limpiar();
            $("#modalPago").modal("show");
        },
        seleccionarimage: function (e) {
            var $this = this;
            $this.file = e.target.files[0];
            var filePath = $(".custom-file #logo").val();
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            if (allowedExtensions.exec(filePath)) {
                var userFile = $(".custom-file #logo");
                userFile.attr("src", URL.createObjectURL(e.target.files[0]));
                var data = userFile.attr("src");
                $(".logo").attr("src", data);

                let fileName = $(".custom-file #logo").val().split("\\").pop();
                $(".custom-file #logo")
                    .next(".custom-file-label")
                    .addClass("selected")
                    .html(fileName);
            } else {
                toastr.error(
                    "Extensión inválida, formatos admitidos (.jpg . jpeg . png)",
                    "Error"
                );
                $(".logo").attr(
                    "src",
                    window.location.origin + "/img/defaultmoney.jpg"
                );
            }
        },
        limpiar: function () {
            this.file = "";
            $(".logo").attr(
                "src",
                window.location.origin + "/img/defaultmoney.jpg"
            );
        },
        reiniciar: function () {
            clearInterval(this.intervalo);
        },
        storePago: function () {
            if (
                parseFloat(this.efectivo) + parseFloat(this.transferencia) >
                this.montoDeuda
            ) {
                toastr.error("El Pago es mayor de lo que se debe");
            } else {
                let $this = this;
                const config = {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                };
                let data = new FormData();
                data.append("documento_venta_id", this.documento_venta_id);
                data.append("efectivo", this.efectivo);
                data.append("transferencia", this.transferencia);
                data.append("forma_pago_id", this.formaPago.id);
                data.append("imagen", this.file);
                axios
                    .post(route("documentoVenta.pago.store"), data, config)
                    .then((value) => {
                        if (value.data.success) {
                            let pagoRow = {};
                            $this.tablePagos.row
                                .add(Object.assign(value.data.data, pagoRow))
                                .draw();
                            $this.montoDeuda = parseFloat(
                                value.data.montoDeuda
                            );
                            $this.table.ajax.reload();
                            $("#modalPago").modal("hide");
                        } else {
                            toastr.error("Ocurrio un error", "error");
                            // $("#modalPago").modal("show");
                        }
                    });
            }
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
