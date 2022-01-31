<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card-min-custom" v-if="!productos.length">
                <div>
                    <h3 class="text-center text-uppercase">
                        No Hay productos Registrados
                    </h3>
                    <lottie-animation path="Json/emptyBox.json" :height="256" />
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-md-3" v-for="item in productos" :key="item.id">
                    <div class="ibox">
                        <div class="ibox-content product-box active">
                            <div style="height: 180px">
                                <img
                                    style="height: 100%; width: 100%"
                                    :src="
                                        item.url_imagen == null
                                            ? rutaOriginal +
                                              '/img/defaultProducto.jpg'
                                            : rutaOriginal +
                                              '/' +
                                              item.url_imagen.replace(
                                                  'public',
                                                  'storage'
                                              )
                                    "
                                    alt=""
                                />
                            </div>
                            <div class="product-desc">
                                <span class="product-price"
                                    >S/. {{ item.precio_venta }}</span
                                >
                                <small class="text-muted"
                                    >Tipo de Producto:
                                    {{ item.tipo_producto.tipo }}</small
                                >
                                <a href="#" class="product-name">{{
                                    item.nombre
                                }}</a>
                                <div class="m-t">
                                    <button
                                        @click="editar(item)"
                                        class="
                                            btn btn-xs btn-outline btn-secondary
                                        "
                                    >
                                        Editar
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button
                                        @click="eliminarProducto(item)"
                                        class="
                                            btn btn-xs btn-outline btn-danger
                                        "
                                    >
                                        Eliminar
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
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
            aria-labelledby="myModalLabel2"
        >
            <div class="modal-dialog" role="document" id="modal-dialog-custom">
                <div class="modal-content" id="modal-content-custom">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">
                            Editar Producto
                        </h4>
                        <div class="ml-2">
                            <button
                                class="btn btn-primary"
                                @click="editarProducto"
                            >
                                <i class="fa fa-plus"></i>Guardar
                            </button>
                        </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="">Tipo Producto</label>
                                        <v-select
                                            v-model="
                                                modelo.obligatorio
                                                    .tipo_producto_id
                                            "
                                            :options="tiposProductos"
                                        >
                                            <span slot="no-options"
                                                >No se encontraron datos</span
                                            >
                                        </v-select>
                                        <span
                                            style="
                                                color: #dc3545;
                                                font-size: 80%;
                                            "
                                            v-if="
                                                errores.tipo_producto_id.error
                                            "
                                        >
                                            <strong>{{
                                                errores.tipo_producto_id.mensaje
                                            }}</strong>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Unidad de Medida</label>
                                        <v-select
                                            v-model="
                                                modelo.obligatorio
                                                    .unidad_medida_id
                                            "
                                            :options="unidadesMedidas"
                                        >
                                            <span slot="no-options"
                                                >No se encontraron datos</span
                                            >
                                        </v-select>
                                        <span
                                            style="
                                                color: #dc3545;
                                                font-size: 80%;
                                            "
                                            v-if="
                                                errores.unidad_medida_id.error
                                            "
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
                                                errores.nombre.error
                                                    ? 'is-invalid'
                                                    : ''
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
                                    <!-- <div class="col-md-6">
                                        <label for="">Tipo de Operacion</label>
                                        <v-select
                                            v-model="
                                                modelo.obligatorio
                                                    .tipo_operacion
                                            "
                                            :options="tiposOperaciones"
                                        >
                                            <span slot="no-options"
                                                >No se encontraron datos</span
                                            >
                                        </v-select>
                                        <span
                                            style="
                                                color: #dc3545;
                                                font-size: 80%;
                                            "
                                            v-if="errores.tipo_operacion.error"
                                        >
                                            <strong>{{
                                                errores.tipo_operacion.mensaje
                                            }}</strong>
                                        </span>
                                    </div> -->
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="">P.Venta</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            :class="
                                                errores.precio_venta.error
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            v-model="
                                                modelo.obligatorio.precio_venta
                                            "
                                        />
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                            v-if="errores.precio_venta.error"
                                        >
                                            <strong>{{
                                                errores.precio_venta.mensaje
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
                                                errores.stock.error
                                                    ? 'is-invalid'
                                                    : ''
                                            "
                                            v-model="modelo.obligatorio.stock"
                                        />
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                            v-if="errores.stock.error"
                                        >
                                            <strong>{{
                                                errores.stock.mensaje
                                            }}</strong>
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">codigo</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            v-model="modelo.otros.codigo"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Logo:</label>
                                                <div class="custom-file">
                                                    <input
                                                        id="logoEditar"
                                                        type="file"
                                                        v-on:change="
                                                            seleccionarImagen
                                                        "
                                                        class="
                                                            custom-file-input
                                                        "
                                                        accept="image/*"
                                                    />
                                                    <label
                                                        for="logo"
                                                        id="logo_txtEditar"
                                                        class="
                                                            custom-file-label
                                                            selected
                                                        "
                                                        >{{
                                                            nombreImagen
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
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
                                        <div class="row mt-1">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-7">
                                                <p>
                                                    <img
                                                        :src="preview"
                                                        class="
                                                            img-fluid
                                                            img-thumbnail
                                                        "
                                                        alt=""
                                                    />
                                                </p>
                                            </div>
                                        </div>
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
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";
export default {
    props: ["tiposProductos", "unidadesMedidas", "tiposOperaciones"],
    components: {
        LottieAnimation,
    },
    data() {
        return {
            modelo: {
                obligatorio: {
                    tipo_producto_id: null,
                    unidad_medida_id: null,
                    precio_venta: "0",
                    stock: "0",
                    nombre: "",
                    // tipo_operacion: null,
                },
                otros: {
                    imagen: "",
                    codigo:""
                },
            },
            id: "",
            preview: "",
            nombreImagen: "",
            errores: {
                // tipo_operacion: {
                //     error: false,
                //     mensaje: "",
                // },
                tipo_producto_id: {
                    error: false,
                    mensaje: "",
                },
                unidad_medida_id: {
                    error: false,
                    mensaje: "",
                },
                precio_venta: {
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
            rutaOriginal: "",
            productos: [],
        };
    },
    created() {
        this.rutaOriginal = window.location.origin;
        this.datos();
    },
    mounted() {
        this.preview = window.location.origin + "/img/defaultProducto.jpg";
        this.modalPersonalizado();
    },
    methods: {
        modalPersonalizado() {
            $("#modal-dialog-custom").css({
                position: "fixed",
                margin: "auto",
                width: "400px",
                height: "100%",
                right: "0px",
            });
            $("#modal-content-custom").css({
                height: "100%",
            });
        },
        datos: async function () {
            var $this = this;
            axios.get(route("producto.getList")).then((value) => {
                $this.productos = value.data;
            });
        },
        editar: function (item) {
            this.limpiarErrores();
            this.id = item.id;
            this.modelo.obligatorio.nombre = item.nombre;
            this.modelo.obligatorio.precio_venta = item.precio_venta;
            this.modelo.obligatorio.stock = item.stock;
            this.modelo.otros.codigo=item.codigo
            this.modelo.obligatorio.tipo_producto_id = {
                code: item.tipo_producto_id,
                label: item.tipo_producto.tipo,
            };
            this.modelo.obligatorio.unidad_medida_id = {
                code: item.unidad_medida_id,
                label: item.unidad_medida.simbolo,
            };
            // this.modelo.obligatorio.tipo_operacion = {
            //     label: item.tipo_operacion,
            // };
            this.nombreImagen = item.nombre_imagen;
            if (item.url_imagen != null) {
                this.preview =
                    window.location.origin +
                    "/" +
                    item.url_imagen.replace("public", "storage");
            } else {
                this.preview =
                    window.location.origin + "/img/defaultProducto.jpg";
            }
            // this.seleccionado = true;
            // this.$nextTick(function () {
            //     window.scroll({
            //         top: 100,
            //         left: 0,
            //         behavior: "smooth",
            //     });
            // });
            $("#modalEdit").modal("show");
        },
        editarProducto: function () {
            var $this = this;
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
                                    this.modelo[keyModelo][key]
                                );
                            } else {
                                data.append(key, this.modelo[keyModelo][key]);
                            }
                        }
                    }
                }
                axios
                    .post(route("producto.update", this.id), data, config)
                    .then((value) => {
                        if (value.data.success) {
                            $this.datos();
                            $("#modalEdit").modal("hide");
                        } else {
                            toast.error("Error", "Ocurrio un Error");
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
            var filePath = $(".custom-file #logoEditar").val();
            var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
            if (allowedExtensions.exec(filePath)) {
                $this.modelo.otros.imagen = e.target.files[0];
                var userFile = $(".custom-file #logoEditar");
                userFile.attr("src", URL.createObjectURL(e.target.files[0]));
                var data = userFile.attr("src");
                // $(".logo").attr("src", data);
                $this.preview = data;

                let fileName = $(".custom-file #logoEditar")
                    .val()
                    .split("\\")
                    .pop();
                $this.nombreImagen = fileName;
            } else {
                toastr.error(
                    "Extensión inválida, formatos admitidos (.jpg . jpeg . png)",
                    "Error"
                );
                $this.preview =
                    window.location.origin + "/img/defaultProducto.jpg";
            }
        },
        limpiar: function () {},
        eliminarProducto: function (item) {
            var $this = this;
            swal({
                title: "Estas seguro?",
                text: "Eliminar Registro!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios
                        .post(route("producto.destroy", item.id))
                        .then((value) => {
                            if (value.data.success) {
                                $this.datos();
                            } else {
                                toastr.error("Ocurrio un Error", "Error");
                            }
                        })
                        .catch((value) => {
                            toastr.error(value);
                        });
                } else {
                    swal("Cancelado", "No se ha eliminado", "error");
                }
            });
        },
    },
};
</script>
<style></style>
