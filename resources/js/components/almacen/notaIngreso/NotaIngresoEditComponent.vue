<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Notas de Ingresos</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Notas de Ingresos</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Crear Nota de Ingreso</strong>
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
                                        <div class="col-md-6">
                                            <label for="">Codigo</label>
                                            <input
                                                type="text"
                                                name="codigo"
                                                id="codigo"
                                                class="form-control"
                                                v-model="obligatorio.codigo"
                                            />
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos.codigo
                                                        .error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos.codigo
                                                        .mensaje
                                                }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="">Descripcion</label>
                                            <textarea
                                                name="descripcion"
                                                id="descripcion"
                                                rows="3"
                                                class="form-control"
                                                v-model="
                                                    obligatorio.descripcion
                                                "
                                            ></textarea>
                                            <span
                                                style="
                                                    color: #dc3545;
                                                    font-size: 80%;
                                                "
                                                v-if="
                                                    errores_externos.codigo
                                                        .error
                                                "
                                            >
                                                <strong>{{
                                                    errores_externos.codigo
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
                                            <h4>Detalle del Nota de Ingreso</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label for=""
                                                        >Productos</label
                                                    >
                                                    <v-select
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
                                                <div class="col-md-3">
                                                    <label for=""
                                                        >Fecha
                                                        Vencimiento</label
                                                    >
                                                    <input
                                                        type="date"
                                                        name="fecha_vencimiento"
                                                        v-model="
                                                            detalle.fecha_vencimiento
                                                        "
                                                        class="form-control"
                                                        :class="
                                                            errores_internos
                                                                .fecha_vencimiento
                                                                .error
                                                                ? 'is-invalid'
                                                                : ''
                                                        "
                                                    />
                                                    <span
                                                        class="invalid-feedback"
                                                        role="alert"
                                                        v-if="
                                                            errores_internos
                                                                .fecha_vencimiento
                                                                .error
                                                        "
                                                    >
                                                        <strong>{{
                                                            errores_internos
                                                                .fecha_vencimiento
                                                                .mensaje
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
                                                        id="tableDetalleNotaIngreso"
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
                                                                <th>
                                                                    Fecha
                                                                    Vencimiento
                                                                </th>
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
        "producto_v",
        "csrf",
        "errores_laravel",
        "error",
        "elemento",
    ],
    data() {
        return {
            select: {
                almacen_id: null,
            },
            obligatorio: {
                fecha_emision: "",
                almacen_id: "",
                codigo: "",
                descripcion: "",
            },
            detalle: {
                producto: null,
                cantidad: null,
                fecha_vencimiento: null,
            },
            errores_externos: {
                fecha_emision: {
                    error: false,
                    mensaje: "",
                },
                almacen_id: {
                    error: false,
                    mensaje: "",
                },
                codigo: {
                    error: false,
                    mensaje: "",
                },
                descripcion: {
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
                fecha_vencimiento: {
                    error: false,
                    mensaje: "",
                },
            },
            ruta: "",
        };
    },
    created() {
        //-------- load Fecha
        this.ruta = route("notaIngreso.update", this.elemento.id);
        var fecha = new Date();
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
            console.log(this.elemento)
            this.obligatorio.descripcion = this.elemento.descripcion;
            this.obligatorio.codigo = this.elemento.codigo;
            this.almacen_v.forEach((value, index, array) => {
                if (value.id == this.elemento.almacen_id) {
                    this.select.almacen_id = value;
                    this.obligatorio.almacen_id = value.id;
                }
            });
            let fecha_emision = new Date(this.elemento.fecha_emision);
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
                this.table.row
                    .add({
                        producto_id: value.producto_id,
                        producto: value.producto.nombre,
                        cantidad: value.cantidad,
                        fecha_vencimiento:value.fecha_vencimiento,
                    })
                    .draw(false);
                this.agregarTablaDetalle();
            })
        },
        tablaInicializar: function () {
            this.table = $("#tableDetalleNotaIngreso").DataTable({
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
                            return data.fecha_vencimiento;
                        },
                    },
                ],
            });
        },
        agregarDetalle: function () {
            if (this.validacionesDetalle()) {
                this.table.row
                    .add({
                        producto_id: this.detalle.producto.id,
                        producto: this.detalle.producto.nombre,
                        cantidad: this.detalle.cantidad,
                        fecha_vencimiento: this.detalle.fecha_vencimiento,
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
