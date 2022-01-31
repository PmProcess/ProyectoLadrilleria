<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 col-md-10">
                <h2 style="text-transform: uppercase">
                    <b>Reportes</b>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a>Reportes Graficos</a>
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
                                <label for="">Reporte de Ventas</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Fecha Inicial:</label>
                                        <input
                                            type="date"
                                            v-model="fechaInicialVenta"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Fecha Final</label>
                                        <input
                                            type="date"
                                            v-model="fechaFinalVenta"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Estado</label>
                                        <select
                                            name="estado"
                                            id="estado"
                                            class="form-control"
                                            v-model="estado"
                                        >
                                            <option value=""></option>
                                            <option value="PENDIENTE">
                                                PENDIENTE
                                            </option>
                                            <option value="PAGADO">
                                                PAGADO
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <button
                                                class="btn btn-primary"
                                                @click="searchReporteVenta"
                                            >
                                                Buscar
                                            </button>
                                            <button
                                                class="btn btn-primary"
                                                @click="pdfReporteVenta"
                                            >
                                                <i class="fa fa-file-pdf-o">
                                                </i>
                                            </button>
                                            <button
                                                class="btn btn-primary"
                                                @click="pdfReporteVentaImg"
                                            >
                                                <i class="fa fa-file-pdf-o">
                                                    Img</i
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <apexchart
                                    type="area"
                                    :height="400"
                                    ref="charventa"
                                    :options="dataVenta"
                                    :series="seriesVenta"
                                ></apexchart>
                            </div>
                            <div class="col-md-12">
                                <label for="">Reporte de Compras</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Fecha Inicial:</label>
                                        <input
                                            type="date"
                                            v-model="fechaInicialCompra"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Fecha Final</label>
                                        <input
                                            type="date"
                                            v-model="fechaFinalCompra"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <button
                                                class="btn btn-primary"
                                                @click="searchReporteCompra"
                                            >
                                                Buscar
                                            </button>
                                            <button
                                                class="btn btn-primary"
                                                @click="pdfReporteCompra"
                                            >
                                                <i class="fa fa-file-pdf-o">
                                                </i>
                                            </button>
                                            <button
                                                class="btn btn-primary"
                                                @click="pdfReporteCompraImg"
                                            >
                                                <i class="fa fa-file-pdf-o">
                                                    Img</i
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <apexchart
                                    type="bar"
                                    :height="400"
                                    ref="barcompra"
                                    :options="dataCompra"
                                    :series="seriesCompra"
                                ></apexchart>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-center text-uppercase">
                                    Top 3 Productos
                                </h4>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Fecha Inicial</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="fechaInicialProducto"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Fecha Final</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="fechaFinalProducto"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button
                                            class="btn btn-primary"
                                            @click="searchReporteProducto"
                                        >
                                            Buscar
                                        </button>
                                        <button
                                            class="btn btn-primary"
                                            @click="pdfReporteProducto"
                                        >
                                            <i class="fa fa-file-pdf-o"> </i>
                                        </button>
                                        <button
                                            class="btn btn-primary"
                                            @click="pdfReporteProductoImg"
                                        >
                                            <i class="fa fa-file-pdf-o"> Img</i>
                                        </button>
                                    </div>
                                </div>
                                <apexchart
                                    type="donut"
                                    height="400"
                                    ref="donutproducto"
                                    :options="dataProducto"
                                    :series="seriesProducto"
                                ></apexchart>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-center text-uppercase">
                                    Top 5 Almacenes mas Usados
                                </h4>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Fecha Inicial</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="fechaInicialAlmacen"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Fecha Final</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="fechaFinalAlmacen"
                                        />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button
                                            class="btn btn-primary"
                                            @click="searchReporteAlmacen"
                                        >
                                            Buscar
                                        </button>
                                        <button
                                            class="btn btn-primary"
                                            @click="pdfReporteAlmacen"
                                        >
                                            <i class="fa fa-file-pdf-o"> </i>
                                        </button>
                                        <button
                                            class="btn btn-primary"
                                            @click="pdfReporteAlmacenImg"
                                        >
                                            <i class="fa fa-file-pdf-o"> Img</i>
                                        </button>
                                    </div>
                                </div>
                                <apexchart
                                    type="polarArea"
                                    height="400"
                                    ref="polaralmacen"
                                    :options="dataAlmacen"
                                    :series="seriesAlmacen"
                                ></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { jsPDF } from "jspdf";
export default {
    data() {
        return {
            fechaInicialVenta: "",
            fechaFinalVenta: "",
            fechaInicialCompra: "",
            fechaFinalCompra: "",
            fechaInicialProducto: "",
            fechaFinalProducto: "",
            fechaInicialAlmacen: "",
            fechaFinalAlmacen: "",
            dataVenta: {},
            seriesVenta: [],
            dataCompra: {},
            seriesCompra: [],
            estado: "",
            dataProducto: {},
            seriesProducto: [],
            dataAlmacen: {},
            seriesAlmacen: [],
        };
    },
    mounted() {},
    methods: {
        searchReporteVenta: async function () {
            if (
                this.fechaInicialVenta.length == 0 ||
                this.fechaFinalVenta.length == 0
            ) {
                toastr.error("Error", "Seleccione el rango de fechas");
                return;
            }
            let datos = await axios.get(route("reporte.getVentas"), {
                params: {
                    fechaInicial: this.fechaInicialVenta,
                    fechaFinal: this.fechaFinalVenta,
                    estado: this.estado,
                },
            });
            var datasets = [];
            this.dataVenta = {
                title: {
                    text: "Ingresos",
                    align: "center",
                },
                xaxis: {
                    stroke: {
                        curve: "smoth",
                    },

                    categories: datos.data.fechas,
                },
            };
            // this.optionsArea.xaxis.categories = datos.data.fechas;
            datasets.push({
                name: "Registro de Documentos de Ventas",
                data: datos.data.data,
            });
            this.seriesVenta = datasets;
        },
        pdfReporteVenta: function () {
            window.open(
                route("reporte.pdfVentas", {
                    fechaInicial: this.fechaInicialVenta,
                    fechaFinal: this.fechaFinalVenta,
                    estado: this.estado,
                }),
                "myWindow",
                "width=900,height=600"
            );
        },
        pdfReporteVentaImg: function () {
            this.$refs.charventa.dataURI().then(({ imgURI, blob }) => {
                // const { jsPDF } = window.jspdf;
                console.log(imgURI);
                const pdf = new jsPDF({
                    orientation: "l",
                    unit: "mm",
                    format: "a4",
                });
                pdf.addImage(imgURI, "PNG", 40, 40);
                pdf.save("pdfVentas.pdf");
            });
        },
        searchReporteCompra: async function () {
            if (
                this.fechaInicialCompra.length == 0 ||
                this.fechaFinalCompra.length == 0
            ) {
                toastr.error("Error", "Seleccione el rango de fechas");
                return;
            }
            let datos = await axios.get(route("reporte.getCompras"), {
                params: {
                    fechaInicial: this.fechaInicialCompra,
                    fechaFinal: this.fechaFinalCompra,
                },
            });
            // console.log(datos);
            var datasets = [];
            this.dataCompra = {
                title: {
                    text: "Egresos",
                    align: "center",
                },
                xaxis: {
                    // stroke: {
                    //     curve: "smoth",
                    // },
                    categories: datos.data.fechas,
                },
            };
            // this.optionsArea.xaxis.categories = datos.data.fechas;
            datasets.push({
                name: "Egresos",
                data: datos.data.data,
            });
            this.seriesCompra = datasets;
        },
        pdfReporteCompra: function () {
            window.open(
                route("reporte.pdfCompras", {
                    fechaInicial: this.fechaInicialCompra,
                    fechaFinal: this.fechaFinalCompra,
                }),
                "myWindow",
                "width=900,height=600"
            );
        },
        pdfReporteCompraImg: function () {
            this.$refs.barcompra.dataURI().then(({ imgURI, blob }) => {
                // const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "l",
                    unit: "mm",
                    format: "a4",
                });
                pdf.addImage(imgURI, "PNG", 40, 40);
                pdf.save("pdfCompras.pdf");
            });
        },
        searchReporteProducto: async function () {
            let datos = await axios.get(route("reporte.getProductos"), {
                params: {
                    fechaInicial: this.fechaInicialProducto,
                    fechaFinal: this.fechaFinalProducto,
                },
            });
            let productosNombre = [];
            let data = [];
            datos.data.forEach((value, index, array) => {
                productosNombre.push(value.nombre);
                data.push(parseFloat(value.cuenta));
            });
            let dataP = {
                labels: productosNombre,
            };
            this.dataProducto = dataP;
            this.seriesProducto = data;
        },
        pdfReporteProducto: function () {
            window.open(
                route("reporte.pdfProductos", {
                    fechaInicial: this.fechaInicialProducto,
                    fechaFinal: this.fechaFinalProducto,
                }),
                "myWindow",
                "width=900,height=600"
            );
        },
        pdfReporteProductoImg: function () {
            this.$refs.donutproducto.dataURI().then(({ imgURI, blob }) => {
                // const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "l",
                    unit: "mm",
                    format: "a4",
                });
                pdf.addImage(imgURI, "PNG", 40, 40);
                pdf.save("pdfproductos.pdf");
            });
        },
        searchReporteAlmacen: async function () {
            let datos = await axios.get(route("reporte.getAlmacen"), {
                params: {
                    fechaInicial: this.fechaInicialAlmacen,
                    fechaFinal: this.fechaFinalAlmacen,
                },
            });
            // console.log(datos);
            let almacenesNombre = [];
            let data = [];
            datos.data.forEach((value, index, array) => {
                almacenesNombre.push(value.nombre);
                data.push(parseFloat(value.cuenta));
            });
            let dataP = {
                labels: almacenesNombre,
                yaxis: {
                    show: false,
                },
            };
            console.log(data);
            this.dataAlmacen = dataP;
            this.seriesAlmacen = data;
        },
        pdfReporteAlmacen: function () {
            window.open(
                route("reporte.pdfAlmacen", {
                    fechaInicial: this.fechaInicialAlmacen,
                    fechaFinal: this.fechaFinalAlmacen,
                }),
                "myWindow",
                "width=900,height=600"
            );
        },
        pdfReporteAlmacenImg: function () {
            this.$refs.polaralmacen.dataURI().then(({ imgURI, blob }) => {
                // const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "l",
                    unit: "mm",
                    format: "a4",
                });
                pdf.addImage(imgURI, "PNG", 40, 40);
                pdf.save("pdfalmacen.pdf");
            });
        },
    },
};
</script>
