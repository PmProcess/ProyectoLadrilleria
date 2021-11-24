<template>
    <div class="row">
        <div class="col-md-12">
            <table
                id="tableNumeracion"
                class="table table-striped table-bordered table-hover"
                style="width: 100%"
            >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Serie</th>
                        <th>N° Iniciar</th>
                        <th>Tipo Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div
            class="modal fade"
            id="modalEdit"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Editar una Numeracion
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
                            <label for="">Tipo Documentos</label>
                            <v-select
                                v-model="modelo.obligatorio.tipo_documento_id"
                                :options="tiposDocumentos"
                            >
                                <span slot="no-options"
                                    >No se encontraron datos</span
                                >
                            </v-select>
                            <span
                                style="color: #dc3545; font-size: 80%"
                                v-if="errores.tipo_documento_id.error"
                            >
                                <strong>{{
                                    errores.tipo_documento_id.mensaje
                                }}</strong>
                            </span>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="">Serie</label>
                                <input
                                    type="text"
                                    maxlength="4"
                                    class="form-control form-control-sm"
                                    :class="
                                        errores.serie.error ? 'is-invalid' : ''
                                    "
                                    v-model="modelo.obligatorio.serie"
                                />
                                <span
                                    class="invalid-feedback"
                                    role="alert"
                                    v-if="errores.serie.error"
                                >
                                    <strong>{{ errores.serie.mensaje }}</strong>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="">Correlativo Iniciar</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
                                    :class="
                                        errores.correlativo_iniciar.error
                                            ? 'is-invalid'
                                            : ''
                                    "
                                    v-model="
                                        modelo.obligatorio.correlativo_iniciar
                                    "
                                />
                                <span
                                    class="invalid-feedback"
                                    role="alert"
                                    v-if="errores.correlativo_iniciar.error"
                                >
                                    <strong>{{
                                        errores.correlativo_iniciar.mensaje
                                    }}</strong>
                                </span>
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
                            @click="edit"
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
import "datatables.net-bs4";
import "datatables.net-buttons-bs4";
// require( 'jszip' );
// require( 'pdfmake' );
// require( 'datatables.net-bs4' )();
// require( 'datatables.net-buttons-bs4' )();
// require( 'datatables.net-buttons/js/buttons.colVis.js' )();
// require( 'datatables.net-buttons/js/buttons.html5.js' )();
// require( 'datatables.net-buttons/js/buttons.print.js' )();
export default {
    props: ["tiposDocumentos"],
    data() {
        return {
            modelo: {
                obligatorio: {
                    tipo_documento_id: "",
                    serie: "",
                    correlativo_iniciar: "",
                },
                otros: {},
            },
            id: "",
            errores: {
                tipo_documento_id: {
                    error: false,
                    mensaje: "",
                },
                serie: {
                    error: false,
                    mensaje: "",
                },
                correlativo_iniciar: {
                    error: false,
                    mensaje: "",
                },
            },
            table: null,
        };
    },
    mounted() {
        var $this = this;
        this.datosInicializado();
        $(document).on("click", ".btn-seleccionar", function (e) {
            var datos = $this.table.row($(this).closest("tr")).data();
            $this.id=datos.id;
            if (datos.seleccionado == "SI") {
                swal({
                    title: "Estas seguro?",
                    text: "De No usar esta serie para sus facturaciones!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        axios
                            .post(route("numeracion.deseleccionar", $this.id))
                            .then((value) => {
                                if (value.data.success) {
                                    $this.table.ajax.reload();
                                } else {
                                    toastr.error(
                                        "Ocurrio un Error",
                                        value.data.mensaje
                                    );
                                }
                            })
                            .catch((value) => {
                                toastr.error(value);
                            });
                    } else {
                        swal("Cancelado", "No se ha eliminado", "error");
                    }
                });
            } else {
                swal({
                    title: "Estas seguro?",
                    text: "Seleccionar esta serie para sus facturaciones!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        axios
                            .post(route("numeracion.seleccionar", $this.id))
                            .then((value) => {
                                if (value.data.success) {
                                    $this.table.ajax.reload();
                                } else {
                                    toastr.error(
                                        "Ocurrio un Error",
                                        value.data.mensaje
                                    );
                                }
                            })
                            .catch((value) => {
                                toastr.error(value);
                            });
                    } else {
                        swal("Cancelado", "No se ha eliminado", "error");
                    }
                });
            }
        });
        $(document).on("click", ".btn-delete", function (e) {
            var datos = $this.table.row($(this).closest("tr")).data();
            $this.id = datos.id;
            swal({
                title: "Estas seguro?",
                text: "Eliminar Registro!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios
                        .post(route("numeracion.destroy", $this.id))
                        .then((value) => {
                            if (value.data.success) {
                                $this.table.ajax.reload();
                            } else {
                                toastr.error(
                                    "Ocurrio un Error",
                                    value.data.mensaje
                                );
                            }
                        })
                        .catch((value) => {
                            toastr.error(value);
                        });
                } else {
                    swal("Cancelado", "No se ha eliminado", "error");
                }
            });
        });
        $(document).on("click", ".btn-edit", function (e) {
            var datos = $this.table.row($(this).closest("tr")).data();
            $this.modelo.obligatorio.serie = datos.serie;
            $this.modelo.obligatorio.correlativo_iniciar =
                datos.correlativo_iniciar;
            $this.modelo.obligatorio.tipo_documento_id = {
                label: datos.tipo_documento.tipo,
                id: datos.tipo_documento.id,
            };
            $this.id = datos.id;
            $this.showModalEdit();
        });
    },
    methods: {
        showModalEdit: function () {
            this.limpiarErrores();
            $("#modalEdit").modal("show");
        },
        datosInicializado: function () {
            this.table = $("#tableNumeracion").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                ajax: route("numeracion.getList"),
                language: {
                    url: window.location.origin + "/Spanish.json",
                    // '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                    },
                    {
                        data: "serie",
                        className: "text-left",
                    },
                    {
                        data: "correlativo_iniciar",
                        className: "text-center",
                    },
                    {
                        data: null,
                        render: function (data) {
                            return data.tipo_documento.tipo;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        width: "20%",
                        render: function (data) {
                            return (
                                "<div class='btn-group'>" +
                                "<button title='Editar Numeracion' class='btn btn-warning btn-sm btn-edit'><i class='fa fa-pencil'></i></button>" +
                                "<button title='Seleccionar Serie para Facturar' class='btn " +
                                (data.seleccionado == "SI"
                                    ? "btn-success btn-seleccionar"
                                    : "btn-secondary btn-seleccionar") +
                                " btn-sm'><i class='fa fa-eye'></i>" +
                                data.seleccionado +
                                "</button>" +
                                "<button title='Eliminar Numeracion' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>" +
                                "</div>"
                            );
                            // return (
                            //     "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-danger  btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                            //     "<li><a class='dropdown-item btn-edit' href='#' title='Modificar' ><b><i class='fa fa-edit'></i>Editar</a></b></li>" +
                            //     "<li><a class='dropdown-item btn-delete'  title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                            //     "</ul></div>"
                            // );
                            // return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown button</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div></div>';
                        },
                    },
                ],
            });
        },
        edit: function () {
            var $this = this;
            if ($this.validaciones()) {
                var data = new FormData();
                for (var keyModelo in this.modelo) {
                    for (var key in this.modelo[keyModelo]) {
                        if (key.includes("id")) {
                            data.append(key, this.modelo[keyModelo][key].id);
                        } else {
                            data.append(key, this.modelo[keyModelo][key]);
                        }
                    }
                }
                axios
                    .post(route("numeracion.update", $this.id), data)
                    .then((value) => {
                        if (value.data.success) {
                            $this.actualizar();
                            $("#modalEdit").modal("hide");
                        } else {
                            toastr.error("Error", value.data.mensaje);
                        }
                    });
            }
        },
        actualizar: function () {
            this.table.ajax.reload();
        },
        validaciones: function () {
            var $this = this;
            var resultado = true;
            var arregloDatos = Object.entries($this.modelo.obligatorio);
            console.log(arregloDatos);
            for (let index = 0; index < arregloDatos.length; index++) {
                if (arregloDatos[index][0].includes("id")) {
                    if (
                        arregloDatos[index][1] == "" ||
                        arregloDatos[index][1] == null
                    ) {
                        $this.errores[arregloDatos[index][0]].error = true;
                        $this.errores[arregloDatos[index][0]].mensaje =
                            "Ingrese el campo " + arregloDatos[index][0];
                        resultado = false;
                    }
                } else {
                    if (arregloDatos[index][1] == "") {
                        $this.errores[arregloDatos[index][0]].error = true;
                        $this.errores[arregloDatos[index][0]].mensaje =
                            "Ingrese el campo " + arregloDatos[index][0];
                        resultado = false;
                    }
                }
            }
            return resultado;
        },
        limpiarErrores: function () {
            var $this = this;
            var arregloErrores = Object.entries($this.errores);
            arregloErrores.forEach((value, index, array) => {
                $this.errores[arregloErrores[index][0]].error = false;
                $this.errores[arregloErrores[index][0]].mensaje = "";
            });
        },
    },
};
</script>
