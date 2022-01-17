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
                        <strong>Crear Documento de Venta</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <form :action="ruta" method="POST" id="frmFactura">
                            <input type="hidden" name="_token" v-model="csrf" />
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="">Fecha Registro</label>
                                            <input
                                                type="date"
                                                name="fecha_registro"
                                                class="form-control"
                                                :class="
                                                    errores_externos
                                                        .fecha_registro.error
                                                        ? 'is-invalid'
                                                        : ''
                                                "
                                                v-model="
                                                    obligatorio.fecha_registro
                                                "
                                            />
                                            <span
                                                class="invalid-feedback"
                                                role="alert"
                                                v-if="
                                                    errores_externos
                                                        .fecha_registro.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .fecha_registro.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""
                                                >Fecha Vencimiento</label
                                            >
                                            <input
                                                type="date"
                                                name="fecha_vencimiento"
                                                class="form-control"
                                                :class="
                                                    errores_externos
                                                        .fecha_vencimiento.error
                                                        ? 'is-invalid'
                                                        : ''
                                                "
                                                v-model="
                                                    obligatorio.fecha_vencimiento
                                                "
                                            />
                                            <span
                                                class="invalid-feedback"
                                                role="alert"
                                                v-if="
                                                    errores_externos
                                                        .fecha_vencimiento.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .fecha_vencimiento
                                                        .mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="">Clientes</label>
                                            <v-select
                                                :options="cliente_v"
                                                label="nombre_completo"
                                                v-model="select.cliente_id"
                                                v-on:input="
                                                    obligatorio.cliente_id =
                                                        select.cliente_id.id
                                                "
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="cliente_id"
                                                v-model="obligatorio.cliente_id"
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos.cliente_id
                                                        .error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos.cliente_id
                                                        .mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="">Forma de Pago</label>
                                            <v-select
                                                :options="formapago_v"
                                                v-model="select.forma_pago_id"
                                                v-on:input="
                                                    obligatorio.forma_pago_id =
                                                        select.forma_pago_id.id
                                                "
                                                label="tipo"
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="forma_pago_id"
                                                v-model="
                                                    obligatorio.forma_pago_id
                                                "
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos
                                                        .forma_pago_id.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .forma_pago_id.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Moneda</label>
                                            <v-select
                                                :options="tipomoneda_v"
                                                v-model="select.tipo_moneda_id"
                                                v-on:input="
                                                    obligatorio.tipo_moneda_id =
                                                        select.tipo_moneda_id.id
                                                "
                                                label="tipo"
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="tipo_moneda_id"
                                                v-model="
                                                    obligatorio.tipo_moneda_id
                                                "
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos
                                                        .tipo_moneda_id.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .tipo_moneda_id.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for=""
                                                >Tipo de Documento</label
                                            >
                                            <v-select
                                                :options="tipodocumento_v"
                                                v-model="
                                                    select.tipo_documento_id
                                                "
                                                v-on:input="
                                                    obligatorio.tipo_documento_id =
                                                        select.tipo_documento_id ==
                                                        null
                                                            ? null
                                                            : select
                                                                  .tipo_documento_id
                                                                  .id
                                                "
                                                label="tipo"
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="tipo_documento_id"
                                                v-model="
                                                    obligatorio.tipo_documento_id
                                                "
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos
                                                        .tipo_documento_id.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .tipo_documento_id
                                                        .mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input
                                    type="hidden"
                                    name="tabladetalle"
                                    id="tabladetalle"
                                />
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4>
                                                Detalle del Documento de Venta
                                            </h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label for=""
                                                        >Productos</label
                                                    >
                                                    <v-select
                                                        v-on:input="
                                                            changeProducto()
                                                        "
                                                        :options="producto_v"
                                                        label="nombre"
                                                        v-model="
                                                            detalle.producto
                                                        "
                                                    >
                                                    </v-select>
                                                    <span
                                                        style="
                                                            color: #dc3545;
                                                            font-size: 80%;
                                                        "
                                                        v-if="
                                                            errores_internos
                                                                .producto.error
                                                        "
                                                    >
                                                        <strong>{{
                                                            errores_internos
                                                                .producto
                                                                .mensaje
                                                        }}</strong>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Stock</label>
                                                    <input
                                                        type="number"
                                                        name=""
                                                        id=""
                                                        v-model="stock"
                                                        readonly
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for=""
                                                        >Cantidad</label
                                                    >
                                                    <input
                                                        type="text"
                                                        name="cantidad"
                                                        v-model="
                                                            detalle.cantidad
                                                        "
                                                        class="form-control"
                                                        :class="
                                                            errores_internos
                                                                .cantidad.error
                                                                ? 'is-invalid'
                                                                : ''
                                                        "
                                                    />
                                                    <span
                                                        class="invalid-feedback"
                                                        role="alert"
                                                        v-if="
                                                            errores_internos
                                                                .cantidad.error
                                                        "
                                                    >
                                                        <strong>{{
                                                            errores_internos
                                                                .cantidad
                                                                .mensaje
                                                        }}</strong>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Precio</label>
                                                    <input
                                                        type="number"
                                                        step="any"
                                                        name="precio"
                                                        v-model="detalle.precio"
                                                        class="form-control"
                                                        :class="
                                                            errores_internos
                                                                .precio.error
                                                                ? 'is-invalid'
                                                                : ''
                                                        "
                                                    />
                                                    <span
                                                        class="invalid-feedback"
                                                        role="alert"
                                                        v-if="
                                                            errores_internos
                                                                .precio.error
                                                        "
                                                    >
                                                        <strong>{{
                                                            errores_internos
                                                                .precio.mensaje
                                                        }}</strong>
                                                    </span>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <button
                                                        class="
                                                            btn
                                                            btn-primary
                                                            btn-sm
                                                        "
                                                        type="button"
                                                        @click="
                                                            agregarDetalle()
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus"
                                                        ></i>
                                                        Agregar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table
                                                        id="tableDetalleDocumentoVenta"
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
                                                                <th>
                                                                    Acciones
                                                                </th>
                                                                <th>
                                                                    Cantidad
                                                                </th>
                                                                <th>
                                                                    Producto
                                                                </th>
                                                                <th>Precio</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-outline"
                                    >
                                        Regresar
                                    </button>
                                    <button
                                        type="button"
                                        @click="enviar"
                                        class="btn btn-primary"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
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
    props: [
        "old",
        "cliente_v",
        "formapago_v",
        "tipodocumento_v",
        "producto_v",
        "tipomoneda_v",
        "csrf",
        "errores_laravel",
        "error",
    ],
    data() {
        return {
            select: {
                cliente_id: null,
                // forma_pago_id: null,
                // tipo_moneda_id: null,
                tipo_documento_id: null,
            },
            obligatorio: {
                fecha_registro: "",
                fecha_vencimiento: "",
                cliente_id: "",
                // forma_pago_id: "",
                // tipo_moneda_id: "",
                tipo_documento_id: "",
            },
            detalle: {
                producto: null,
                cantidad: null,
                precio: null,
            },
            errores_externos: {
                fecha_registro: {
                    error: false,
                    mensaje: "",
                },
                fecha_vencimiento: {
                    error: false,
                    mensaje: "",
                },
                cliente_id: {
                    error: false,
                    mensaje: "",
                },
                // forma_pago_id: {
                //     error: false,
                //     mensaje: "",
                // },
                // tipo_moneda_id: {
                //     error: false,
                //     mensaje: "",
                // },
                tipo_documento_id: {
                    error: false,
                    mensaje: "",
                },
            },
            errores_internos: {
                producto: {
                    error: false,
                    mensaje: "",
                },
                cantidad: {
                    error: false,
                    mensaje: "",
                },
                precio: {
                    error: false,
                    mensaje: "",
                },
            },
            ruta: "",
            stock: 0,
        };
    },
    created() {
        //-------- load Fecha
        var $this = this;
        this.ruta = route("documentoVenta.store");
        var fecha = new Date();
        this.obligatorio.fecha_vencimiento =
            fecha.getFullYear() +
            "-" +
            (fecha.getMonth() + 1 < 10
                ? "0" + (fecha.getMonth() + 1)
                : fecha.getMonth() + 1) +
            "-" +
            (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
        this.obligatorio.fecha_registro =
            fecha.getFullYear() +
            "-" +
            (fecha.getMonth() + 1 < 10
                ? "0" + (fecha.getMonth() + 1)
                : fecha.getMonth() + 1) +
            "-" +
            (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
        console.log(
            fecha.getFullYear() +
                "-" +
                (fecha.getMonth() + 1 < 10
                    ? "0" + (fecha.getMonth() + 1)
                    : fecha.getMonth() + 1) +
                "-" +
                (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate())
        );
    },
    mounted() {
        var $this = this;
        let i = Object.entries(this.old);
        i.forEach((value, index, array) => {
            if ($this.obligatorio[i[index][0]] != undefined) {
                if (i[index][0].includes("id")) {
                    $this[
                        i[index][0].replace("_id", "").replace("_", "") + "_v"
                    ].forEach((value, index_c, array) => {
                        if (i[index][1] == value.id) {
                            $this.select[i[index][0]] = value;
                            $this.obligatorio[i[index][0]] = value.id;
                        }
                    });
                } else {
                    $this.obligatorio[i[index][0]] = i[index][1];
                }
            }
        });
        //-------------------------------------------
        if (this.errores_laravel != null) {
            let e = Object.entries(this.errores_laravel);
            e.forEach((value, index, array) => {
                $this.errores_externos[e[index][0]].error = true;
                $this.errores_externos[e[index][0]].mensaje = e[index][1][0];
            });
        }
        //--------------------------------------------
        this.tablaInicializar();
        $(document).on("click", ".btn-eliminar", function (e) {
            $this.table.row($(this).closest("tr")).remove().draw();
            $this.agregarTablaDetalle();
        });
        //--------------------------------------
        if (this.error != null) {
            this.$swal.fire({
                icon: "error",
                title: "Oops...",
                text: this.error,
            });
        }
    },
    methods: {
        datosOld: function () {},
        tablaInicializar: function () {
            this.table = $("#tableDetalleDocumentoVenta").DataTable({
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: false,
                processing: true,
                language: {
                    url: window.location.origin + "/Spanish.json",
                },
                columnDefs: [
                    {
                        targets: [0],
                        className: "text-center",
                        data: null,
                        render: function (data) {
                            return (
                                "<div class='btn-group'>" +
                                "<button class='btn btn-danger btn-eliminar'><i class='fa fa-trash'></i></button>" +
                                "</div>"
                            );
                        },
                    },
                    {
                        targets: [1],
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.cantidad;
                        },
                    },
                    {
                        targets: [2],
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.producto;
                        },
                    },
                    {
                        targets: [3],
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.precio;
                        },
                    },
                    {
                        targets: [4],
                        data: null,
                        className: "text-center",
                        render: function (data) {
                            return data.total;
                        },
                    },
                ],
            });
        },
        changeProducto: function () {
            this.detalle.precio =
                this.detalle.producto != null
                    ? this.detalle.producto.precio_venta
                    : 0;
            this.stock =
                this.detalle.producto != null ? this.detalle.producto.stock : 0;
        },
        agregarDetalle: function () {
            if (this.validacionesDetalle()) {
                if (
                    parseFloat(this.stock) > 0 &&
                    parseFloat(this.detalle.cantidad) <= parseFloat(this.stock)
                ) {
                    this.table.row
                        .add({
                            producto_id: this.detalle.producto.id,
                            producto: this.detalle.producto.nombre,
                            cantidad: this.detalle.cantidad,
                            precio: this.detalle.precio,
                            total: this.detalle.cantidad * this.detalle.precio,
                        })
                        .draw(false);
                    this.agregarTablaDetalle();
                } else {
                    toastr.error("El stock no cumple");
                }
            }
        },
        agregarTablaDetalle: function () {
            var datos = [];
            this.table
                .rows()
                .data()
                .each((value, index, array) => {
                    datos.push(value);
                });
            $("#tabladetalle").val(JSON.stringify(datos));
        },
        validacionesDetalle: function () {
            var resultado = true;
            var $this = this;
            var datos = Object.entries(this.detalle);
            for (let index = 0; index < datos.length; index++) {
                if (datos[index][1] == "" || datos[index][1] == null) {
                    $this.errores_internos[datos[index][0]].error = true;
                    $this.errores_internos[datos[index][0]].mensaje =
                        "Ingrese el campo " + datos[index][0];
                    resultado = false;
                }
            }
            return resultado;
        },
        enviar: function () {
            if (!this.table.data().count()) {
                toastr.error("Detalle Vacio");
            } else {
                $("#frmFactura").submit();
            }
        },
    },
};
</script>
<style>
.swal2-container {
    z-index: 4000;
}
</style>
