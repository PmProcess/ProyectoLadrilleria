<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Numeracion</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Numeracion</a>
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
                                        @click="openModalStore"
                                    >
                                        <i
                                            class="fa fa-plus"
                                            aria-hidden="true"
                                        ></i>
                                        Agregar Numeracion
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <datatable-numeracion-component
                                    ref="NumeracionDatatable"
                                    :tiposDocumentos="tiposDocumentos"
                                ></datatable-numeracion-component>
                                <!-- <datatable-tipo-producto-component
                                    ref="datatableTipoProducto"
                                >
                                </datatable-tipo-producto-component> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="modalCreate"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Crear un nueva Numeracion
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
                            @click="storeNumeracion"
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
import DatatableNumeracionComponent from "../../datatables/Numeracion/DatatableNumeracionComponent.vue";
export default {
    components: { DatatableNumeracionComponent },
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
            tiposDocumentos: [],
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
        };
    },
    mounted() {
        this.datos();
    },
    methods: {
        datos: async function () {
            var $this = this;
            axios.get(route("tipoDocumento.getList")).then((value) => {
                let datos = value.data.data;
                datos.forEach((value, index, array) => {
                    $this.tiposDocumentos.push({
                        label: value.tipo,
                        id: value.id,
                    });
                });
            });
        },
        openModalStore: function () {
            this.limpiarErrores();
            $("#modalCreate").modal("show");
        },
        storeNumeracion: function () {
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
                axios.post(route("numeracion.store"), data).then((value) => {
                    if (value.data.success) {
                        $this.$refs.NumeracionDatatable.actualizar();
                        $("#modalCreate").modal("hide");
                    } else {
                        toastr.error("Error", value.data.mensaje);
                    }
                });
            }
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
