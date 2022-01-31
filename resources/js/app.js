/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from "vue";
import helperJs from "./helpers.js";
import vSelect from "vue-select";
import VueIframe from "vue-iframes";
import Verte from "verte";
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)
const options = {
    confirmButtonColor: "#41b882",
    cancelButtonColor: "#ff7674",
};
import VueSweetalert2 from "vue-sweetalert2";
// import { Photoshop } from 'vue-color'
// import { Slider } from 'vue-color'
// fs.writeFile('calc1.js','console.log("done")',function(errr){
//     console.log("Exito archivo")
// })
Vue.use(VueSweetalert2,options);
Vue.use(VueIframe);
// Vue.config.devtools = false;
// import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue"
Vue.component("v-select", vSelect);
Vue.component("verte", Verte);
// new Vue({
//     components: {
//       'photoshop-picker': Photoshop
//     }
//   })
// Vue.component("photoshop-picker",Photoshop)
// Vue.component("slider-picker",Slider)
require("./bootstrap");

window.Vue = require("vue").default;
const plugin = {
    install() {
        Vue.helperJs = helperJs;
        Vue.prototype.$helperJs = helperJs;
    },
};
Vue.use(plugin);
// Vue.use(LottieAnimation);
// const $ = require("jquery");
// window.$ = $;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "tipoempleadoindex-component",
    require("./components/administracion/tipoEmpleado/TipoEmpleadoIndexComponent.vue")
        .default
);
Vue.component(
    "tipodocumentoindex-component",
    require("./components/configuracion/TipoDocumento/TipoDocumentoIndexComponent.vue")
        .default
);
Vue.component(
    "tipoproductoindex-component",
    require("./components/ventas/tipoProducto/TipoProductoIndexComponent.vue")
        .default
);
Vue.component(
    "empresapersonalindex-component",
    require("./components/mantenimiento/EmpresaPersonal/EmpresaPersonalIndexComponent.vue")
        .default
);
Vue.component(
    "unidadmedidaindex-component",
    require("./components/mantenimiento/UnidadMedida/UnidadMedidaIndexComponent.vue")
        .default
);
Vue.component(
    "empleado-index-component",
    require("./components/administracion/Empleado/EmpleadoIndexComponent.vue")
        .default
);
Vue.component(
    "empleadocreate-component",
    require("./components/administracion/Empleado/EmpleadoCreateComponent.vue")
        .default
);
Vue.component(
    "api-index-component",
    require("./components/administracion/Api/ApiIndexComponent.vue").default
);
Vue.component(
    "cliente-index-component",
    require("./components/administracion/Cliente/ClienteIndexComponent.vue")
        .default
);
Vue.component(
    "proveedor-index-component",
    require("./components/administracion/Proveedor/ProveedorIndexComponent.vue")
        .default
);
Vue.component(
    "almacenindex-component",
    require("./components/mantenimiento/Almacen/AlmacenIndexComponent.vue")
        .default
);
Vue.component(
    "productoindex-component",
    require("./components/ventas/Producto/ProductoIndexComponent.vue").default
);
Vue.component(
    "insumoindex-component",
    require("./components/compras/Insumo/InsumoIndexComponent.vue").default
);
Vue.component(
    "numeracionindex-component",
    require("./components/configuracion/Numeracion/NumeracionIndexComponent.vue")
        .default
);
Vue.component(
    "documentoventaindex-component",
    require("./components/ventas/documentoVentas/DocumentoVentaIndexComponent.vue")
        .default
);
Vue.component(
    "documentoventacreate-component",
    require("./components/ventas/documentoVentas/DocumentoVentaCreateComponent.vue")
        .default
);
Vue.component(
    "cotizacionindex-component",
    require("./components/ventas/cotizacion/CotizacionIndexComponent.vue")
        .default
);
Vue.component(
    "cotizacionedit-component",
    require("./components/ventas/cotizacion/CotizacionEditComponent.vue")
        .default
);
Vue.component(
    "documentocompraindex-component",
    require("./components/compras/documentoCompra/DocumentoCompraIndexComponent.vue")
        .default
);
Vue.component(
    "documentocompracreate-component",
    require("./components/compras/documentoCompra/DocumentoCompraCreateComponent.vue")
        .default
);
Vue.component(
    "documentocompraedit-component",
    require("./components/compras/documentoCompra/DocumentoCompraEditComponent.vue")
        .default
);

Vue.component(
    "notaingresoindex-component",
    require("./components/almacen/notaIngreso/NotaIngresoIndexComponent.vue")
        .default
);
Vue.component(
    "notaingresocreate-component",
    require("./components/almacen/notaIngreso/NotaIngresoCreateComponent.vue")
        .default
);
Vue.component(
    "notaingresoedit-component",
    require("./components/almacen/notaIngreso/NotaIngresoEditComponent.vue")
        .default
);
//Datatable

Vue.component(
    "datatabletipoempleado-component",
    require("./components/datatables/tipoEmpleado/DatatableTipoEmpleadoComponent.vue")
        .default
);
Vue.component(
    "datatabletipoproducto-component",
    require("./components/datatables/TipoProducto/DatatableTipoProductoComponent.vue")
        .default
);
Vue.component(
    "datatableempleado-component",
    require("./components/datatables/Empleado/DatatableEmpleadoComponent.vue")
        .default
);
Vue.component(
    "datatableapi-component",
    require("./components/datatables/Api/DatatableApiComponent.vue")
);
Vue.component(
    "datatablecliente-component",
    require("./components/datatables/Cliente/DatatableClienteComponent.vue")
);
Vue.component(
    "datatableproveedor-component",
    require("./components/datatables/Proveedor/DatatableProveedorComponent.vue")
);
Vue.component(
    "datatableunidadmedida-component",
    require("./components/datatables/UnidadMedida/DatatableUnidadMedidaComponent.vue")
);
Vue.component(
    "datatablealmacen-component",
    require("./components/datatables/Almacen/DatatableAlmacenComponent.vue")
);
Vue.component(
    "reporte-component",
    require("./components/reportes/Reporte/ReporteComponent.vue").default
);


Vue.component(
    "documentoventacotizacioncreate-component",
    require("./components/ventas/cotizacion/CotizacionCreateDocumentoComponent.vue")
        .default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var vue = new Vue({
    el: "#app",
});
