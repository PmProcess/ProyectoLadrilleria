<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Insumo</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Insumo</a>
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
                                        Agregar Insumo
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <insumo-lista-component
                                    ref="InsumoList"
                                    v-bind:unidadesMedidas="unidadesMedidas"
                                ></insumo-lista-component>
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
                            Crear un nuevo Insumo
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
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="">codigo</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="modelo.otros.codigo"
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="">Unidad de Medida</label>
                                <v-select
                                    v-model="
                                        modelo.obligatorio.unidad_medida_id
                                    "
                                    :options="unidadesMedidas"
                                >
                                    <span slot="no-options"
                                        >No se encontraron datos</span
                                    >
                                </v-select>
                                <span
                                    style="color: #dc3545; font-size: 80%"
                                    v-if="errores.unidad_medida_id.error"
                                >
                                    <strong>{{
                                        errores.unidad_medida_id.mensaje
                                    }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="">Nombre</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    :class="
                                        errores.nombre.error ? 'is-invalid' : ''
                                    "
                                    v-model="modelo.obligatorio.nombre"
                                />
                                <span
                                    class="invalid-feedback"
                                    role="alert"
                                    v-if="errores.nombre.error"
                                >
                                    <strong>{{
                                        errores.nombre.mensaje
                                    }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="">Precio Venta</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
                                    :class="
                                        errores.precio.error
                                            ? 'is-invalid'
                                            : ''
                                    "
                                    v-model="modelo.obligatorio.precio"
                                />
                                <span
                                    class="invalid-feedback"
                                    role="alert"
                                    v-if="errores.precio.error"
                                >
                                    <strong>{{
                                        errores.precio.mensaje
                                    }}</strong>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="">stock</label>
                                <input
                                    readonly
                                    type="text"
                                    class="form-control form-control-sm"
                                    :class="
                                        errores.stock.error ? 'is-invalid' : ''
                                    "
                                    v-model="modelo.obligatorio.stock"
                                />
                                <span
                                    class="invalid-feedback"
                                    role="alert"
                                    v-if="errores.stock.error"
                                >
                                    <strong>{{ errores.stock.mensaje }}</strong>
                                </span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label id="logo_label">Logo:</label>
                                        <div class="custom-file">
                                            <input
                                                id="logo"
                                                type="file"
                                                name="logo"
                                                v-on:change="seleccionarImagen"
                                                class="custom-file-input"
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
                                <div class="row mt-2">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                        <div class="row justify-content-end">
                                            <a
                                                href="javascript:void(0);"
                                                id="limpiar_logo"
                                                v-on:click="limpiar"
                                            >
                                                <span class="badge badge-danger"
                                                    >x</span
                                                >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                        <p>
                                            <img
                                                id="imagenLogon"
                                                class="
                                                    logo
                                                    img-fluid img-thumbnail
                                                "
                                                alt=""
                                            />
                                        </p>
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
                            @click="storeInsumo"
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
import InsumoListaComponent from "./InsumoListaComponent.vue";
export default {
    components: { InsumoListaComponent },
    data() {
        return {
            modelo: {
                obligatorio: {
                    unidad_medida_id: null,
                    precio: "0",
                    stock: "0",
                    nombre: "",
                },
                otros: {
                    imagen: "",
                    codigo: "",
                },
            },
            tiposOperaciones: [
                {
                    label: "VENTA",
                },
            ],
            unidadesMedidas: [],
            errores: {
                unidad_medida_id: {
                    error: false,
                    mensaje: "",
                },
                precio: {
                    error: false,
                    mensaje: "",
                },
                stock: {
                    error: false,
                    mensaje: "",
                },
                nombre: {
                    error: false,
                    mensaje: "",
                },
                imagen: {
                    error: false,
                    mensaje: "",
                },
            },
        };
    },
    created() {},
    mounted() {
        $("#modalCreate .logo").attr(
            "src",
            window.location.origin + "/img/defaultInsumo.jpg"
        );
        this.datos();
    },
    methods: {
        datos: async function () {
            await axios.get(route("unidadMedida.getList")).then((value) => {
                value.data.data.forEach((value, index, array) => {
                    this.unidadesMedidas.push({
                        label: value.simbolo,
                        code: value.id,
                    });
                });
            });
        },
        openModalStore: function () {
            this.limpiarErrores();
            $("#modalCreate").modal("show");
        },
        storeInsumo: function () {
            var $this = this;
            this.limpiarErrores();
            if (this.validaciones()) {
                const config = {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                };
                var data = new FormData();
                for (var keyModelo in this.modelo) {
                    for (var key in this.modelo[keyModelo]) {
                        if (key.includes("id")) {
                            data.append(key, this.modelo[keyModelo][key].code);
                        } else {
                            if (
                                typeof this.modelo[keyModelo][key] ===
                                    "object" &&
                                key != "imagen"
                            ) {
                                data.append(
                                    key,
                                    this.modelo[keyModelo][key].label
                                );
                            } else {
                                data.append(key, this.modelo[keyModelo][key]);
                            }
                        }
                    }
                }
                axios
                    .post(route("insumo.store"), data, config)
                    .then((value) => {
                        if (value.data.success) {
                            $this.$refs.InsumoList.datos();
                            $this.limpiarDatos();
                            $("#modalCreate").modal("hide");
                        } else {
                            toastr.error("Error", "Ocurrio un Error");
                        }
                    });
            }
        },
        limpiarErrores: function () {
            var $this = this;
            var arregloErrores = Object.entries($this.errores);
            arregloErrores.forEach((value, index, array) => {
                $this.errores[arregloErrores[index][0]].error = false;
                $this.errores[arregloErrores[index][0]].mensaje = "";
            });
        },
        validaciones: function () {
            var $this = this;
            var resultado = true;
            var arregloDatos = Object.entries($this.modelo.obligatorio);
            for (let index = 0; index < arregloDatos.length; index++) {
                if (arregloDatos[index][0].includes("id")) {
                    if (arregloDatos[index][1] == null) {
                        $this.errores[arregloDatos[index][0]].error = true;
                        $this.errores[arregloDatos[index][0]].mensaje =
                            "Ingrese el campo " + arregloDatos[index][0];
                        resultado = false;
                    }
                } else {
                    if (
                        arregloDatos[index][1] == "" ||
                        arregloDatos[index][1] == null
                    ) {
                        $this.errores[arregloDatos[index][0]].error = true;
                        $this.errores[arregloDatos[index][0]].mensaje =
                            "Ingrese el campo " + arregloDatos[index][0];
                        resultado = false;
                    }
                }
            }
            return resultado;
        },
        seleccionarImagen: function (e) {
            var $this = this;
            $this.modelo.otros.imagen = e.target.files[0];
            var filePath = $(".custom-file #logo").val();
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            if (allowedExtensions.exec(filePath)) {
                var userFile = $(".custom-file #logo");
                userFile.attr("src", URL.createObjectURL(e.target.files[0]));
                var data = userFile.attr("src");
                $(".logo").attr("src", data);
                let fileName = $(".custom-file #logo").val().split("\\").pop();
                $("#logo_txt").html(fileName);
            } else {
                toastr.error(
                    "Extensión inválida, formatos admitidos (.jpg . jpeg . png)",
                    "Error"
                );
                $(".logo").attr(
                    "src",
                    window.location.origin + "/img/defaultInsumo.jpg"
                );
            }
        },
        limpiarDatos: function () {
            for (var keyModelo in this.modelo) {
                for (var key in this.modelo[keyModelo]) {
                    if (key.includes("id")) {
                        this.modelo[keyModelo][key] = {};
                    } else {
                        if (typeof this.modelo[keyModelo][key] === "object") {
                            this.modelo[keyModelo][key] = {};
                        } else {
                            this.modelo[keyModelo][key] = "";
                        }
                    }
                }
            }
            this.modelo.obligatorio.stock = "0";
            $(".logo").attr(
                "src",
                window.location.origin + "/img/defaultInsumo.jpg"
            );
        },
        limpiar: function () {},
    },
};
</script>
<style>
.img-thumbnail-custom {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    max-width: 100%;
    height: auto;
}
.img-container-custom {
    margin-top: 20px;
    padding: 0px 50px 0px 50px;
}
</style>
