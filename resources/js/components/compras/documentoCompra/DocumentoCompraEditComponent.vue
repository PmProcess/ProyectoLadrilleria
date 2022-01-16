<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Documentos de Compras</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Documentos de Compras</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Editar Documento de Compra</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <form :action="ruta" method="POST">
                            <input type="hidden" name="_token" v-model="csrf" />
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="">Fecha Emision</label>
                                            <input
                                                type="date"
                                                name="fecha_emision"
                                                class="form-control"
                                                :class="
                                                    errores_externos
                                                        .fecha_emision.error
                                                        ? 'is-invalid'
                                                        : ''
                                                "
                                                v-model="
                                                    obligatorio.fecha_emision
                                                "
                                            />
                                            <span
                                                class="invalid-feedback"
                                                role="alert"
                                                v-if="
                                                    errores_externos
                                                        .fecha_emision.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .fecha_emision.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Fecha Entrega</label>
                                            <input
                                                type="date"
                                                name="fecha_entrega"
                                                class="form-control"
                                                :class="
                                                    errores_externos
                                                        .fecha_entrega.error
                                                        ? 'is-invalid'
                                                        : ''
                                                "
                                                v-model="
                                                    obligatorio.fecha_entrega
                                                "
                                            />
                                            <span
                                                class="invalid-feedback"
                                                role="alert"
                                                v-if="
                                                    errores_externos
                                                        .fecha_entrega.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .fecha_entrega.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="">Proveedor</label>
                                            <v-select
                                                :options="proveedor_v"
                                                label="nombre_completo"
                                                v-model="select.proveedor_id"
                                                v-on:input="
                                                    obligatorio.proveedor_id =
                                                        select.proveedor_id.id
                                                "
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="proveedor_id"
                                                v-model="
                                                    obligatorio.proveedor_id
                                                "
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos
                                                        .proveedor_id.error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos
                                                        .proveedor_id.mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <label for="">Almacen</label>
                                            <v-select
                                                :options="almacen_v"
                                                v-model="select.almacen_id"
                                                v-on:input="
                                                    obligatorio.almacen_id =
                                                        select.almacen_id ==
                                                        null
                                                            ? null
                                                            : select.almacen_id
                                                                  .id
                                                "
                                                label="nombre"
                                            ></v-select>
                                            <input
                                                type="hidden"
                                                name="almacen_id"
                                                v-model="obligatorio.almacen_id"
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos.almacen_id
                                                        .error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos.almacen_id
                                                        .mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="">Numeracion</label>
                                            <input
                                                type="text"
                                                name="numeracion"
                                                id="numeracion"
                                                class="form-control"
                                                v-model="obligatorio.numeracion"
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos.numeracion
                                                        .error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos.numeracion
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
                                                Detalle del Documento de Compra
                                            </h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label for=""
                                                        >Insumos</label
                                                    >
                                                    <v-select
                                                        v-on:input="
                                                            changeInsumo()
                                                        "
                                                        :options="insumo_v"
                                                        label="nombre"
                                                        v-model="detalle.insumo"
                                                    >
                                                    </v-select>
                                                    <span
                                                        style="
                                                            color: #dc3545;
                                                            font-size: 80%;
                                                        "
                                                        v-if="
                                                            errores_internos
                                                                .insumo.error
                                                        "
                                                    >
                                                        <strong>{{
                                                            errores_internos
                                                                .insumo.mensaje
                                                        }}</strong>
                                                    </span>
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
                                                        id="tableDetalleDocumentoCompra"
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
                                                                <th>Insumo</th>
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
                                        type="submit"
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
        "proveedor_v",
        "almacen_v",
        "tipodocumento_v",
        "insumo_v",
        "csrf",
        "errores_laravel",
        "error",
        "elemento",
    ],
    data() {
        return {
            select: {
                proveedor_id: null,
                tipo_documento_id: null,
                almacen_id: null,
            },
            obligatorio: {
                fecha_emision: "",
                fecha_entrega: "",
                proveedor_id: "",
                tipo_documento_id: "",
                almacen_id: "",
                numeracion: "",
            },
            detalle: {
                insumo: null,
                cantidad: null,
                precio: null,
            },
            errores_externos: {
                fecha_emision: {
                    error: false,
                    mensaje: "",
                },
                fecha_entrega: {
                    error: false,
                    mensaje: "",
                },
                proveedor_id: {
                    error: false,
                    mensaje: "",
                },
                tipo_documento_id: {
                    error: false,
                    mensaje: "",
                },
                almacen_id: {
                    error: false,
                    mensaje: "",
                },
                numeracion: {
                    error: false,
                    mensaje: "",
                },
            },
            errores_internos: {
                insumo: {
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
            table:null
        };
    },
    created() {
        this.ruta = route("documentoCompra.update", this.elemento.id);
        var fecha = new Date();
        this.obligatorio.fecha_entrega =
            fecha.getFullYear() +
            "-" +
            (fecha.getMonth() + 1 < 10
                ? "0" + (fecha.getMonth() + 1)
                : fecha.getMonth() + 1) +
            "-" +
            (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
        this.obligatorio.fecha_emision =
            fecha.getFullYear() +
            "-" +
            (fecha.getMonth() + 1 < 10
                ? "0" + (fecha.getMonth() + 1)
                : fecha.getMonth() + 1) +
            "-" +
            (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
    },
    mounted() {
        var $this = this;
        this.tablaInicializar();
        this.setElemento();
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
        setElemento: function () {
            // obligatorio: {
            //     fecha_emision: "",
            //     fecha_entrega: "",
            //     numeracion: "",
            // }
            // this.prove
            // this.select.proveedor_id=this.elemento.proveedor_id
            // this.select.tipo_documento_id=this.elemento.tipo_documento_id
            // this.select.almacen_id=this.elemento.almacen_id
            console.log(this.elemento);
            let $this=this;
            this.proveedor_v.forEach((value, index, array) => {
                if (value.id == this.elemento.proveedor_id) {
                    this.select.proveedor_id = value;
                    this.obligatorio.proveedor_id = value.id;
                }
            });
            this.tipodocumento_v.forEach((value, index, array) => {
                if (value.id == this.elemento.tipo_documento_id) {
                    this.select.tipo_documento_id = value;
                    this.obligatorio.tipo_documento_id = value.id;
                }
            });
            this.almacen_v.forEach((value, index, array) => {
                if (value.id == this.elemento.almacen_id) {
                    this.select.almacen_id = value;
                    this.obligatorio.almacen_id = value.id;
                }
            });
            this.obligatorio.numeracion = this.elemento.numeracion;

            let fecha_emision = new Date(this.elemento.fecha_emision);
            let fecha_entrega = new Date(this.elemento.fecha_entrega);
            this.obligatorio.fecha_entrega =
                fecha_entrega.getFullYear() +
                "-" +
                (fecha_entrega.getMonth() + 1 < 10
                    ? "0" + (fecha_entrega.getMonth() + 1)
                    : fecha_entrega.getMonth() + 1) +
                "-" +
                (fecha_entrega.getDate() < 10
                    ? "0" + fecha_entrega.getDate()
                    : fecha_entrega.getDate());

            this.obligatorio.fecha_emision =
                fecha_emision.getFullYear() +
                "-" +
                (fecha_emision.getMonth() + 1 < 10
                    ? "0" + (fecha_emision.getMonth() + 1)
                    : fecha_emision.getMonth() + 1) +
                "-" +
                (fecha_emision.getDate() < 10
                    ? "0" + fecha_emision.getDate()
                    : fecha_emision.getDate());

            this.elemento.detalle.forEach((value, index, array) => {
                $this.table.row
                    .add({
                        insumo_id: value.insumo_id,
                        insumo: value.insumo.nombre,
                        cantidad: value.cantidad,
                        precio: value.precio,
                        total: value.cantidad * value.precio,
                    })
                    .draw(false);
                this.agregarTablaDetalle();
            })
        },
        tablaInicializar: function () {
            this.table = $("#tableDetalleDocumentoCompra").DataTable({
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
                            return data.insumo;
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
        changeInsumo: function () {
            this.detalle.precio =
                this.detalle.insumo != null
                    ? this.detalle.insumo.precio
                    : 0;
        },
        agregarDetalle: function () {
            if (this.validacionesDetalle()) {
                this.table.row
                    .add({
                        insumo_id: this.detalle.insumo.id,
                        insumo: this.detalle.insumo.nombre,
                        cantidad: this.detalle.cantidad,
                        precio: this.detalle.precio,
                        total: this.detalle.cantidad * this.detalle.precio,
                    })
                    .draw(false);
                this.agregarTablaDetalle();
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
    },
};
</script>
<style>
.swal2-container {
    z-index: 4000;
}
</style>
