<template>
    <div
        class="modal fade"
        id="modalRecibo"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Editar Pdf - Recibo de Venta
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
                    <div class="row">
                        <div class="col-md-6" v-if="previewPdf">
                            <vue-iframe :src="src" style="height: 450px" />
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7">
                                    <fieldset>
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Imagen</label
                                        >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input
                                                    type="radio"
                                                    name="imagenAlign"
                                                    value="left"
                                                    v-model="
                                                        json[0].Recibo.imagen
                                                            .align
                                                    "
                                                />
                                                <label>Izquierda</label>
                                                <br />
                                                <input
                                                    type="radio"
                                                    name="imagenAlign"
                                                    value="right"
                                                    v-model="
                                                        json[0].Recibo.imagen
                                                            .align
                                                    "
                                                />
                                                <label>Derecha</label>
                                                <br />
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Ver Imagen</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .imagen.show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="example1"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="example1"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Cliente</label
                                        >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Direccion</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .direccion
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="direccion"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="direccion"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Tipo Moneda</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .tipoMoneda
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="tipoMoneda"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="tipoMoneda"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Forma de Pago</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .formaPago
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="formaPago"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="formaPago"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Tabla-Header</label
                                        >
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Color de
                                                            Border</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .table.header
                                                                    .borderColor
                                                            "
                                                            picker="wheel"
                                                            menuPosition="top"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Fondo</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .table.header
                                                                    .backgroundColor
                                                            "
                                                            picker="wheel"
                                                            menuPosition="top"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Color de
                                                            Letra</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .table.header
                                                                    .color
                                                            "
                                                            picker="wheel"
                                                            menuPosition="top"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Direccion</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .direccion
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="direccion"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="direccion"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Tipo Moneda</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .tipoMoneda
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="tipoMoneda"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="tipoMoneda"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Forma de Pago</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cliente
                                                                    .formaPago
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="formaPago"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="formaPago"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </fieldset>
                                </div>
                                <div class="col-md-5">
                                    <fieldset>
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Recuadro</label
                                        >
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Color de
                                                            Border</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cuadroDocumento
                                                                    .borderColor
                                                            "
                                                            picker="wheel"
                                                            menuPosition="right"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Serie-Fondo</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cuadroDocumento
                                                                    .serie
                                                                    .backgroundColor
                                                            "
                                                            picker="wheel"
                                                            menuPosition="right"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for=""
                                                            >Serie-Color de
                                                            Letra</label
                                                        >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <verte
                                                            v-model="
                                                                json[0].Recibo
                                                                    .cuadroDocumento
                                                                    .serie.color
                                                            "
                                                            picker="wheel"
                                                            menuPosition="right"
                                                            model="hex"
                                                        >
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M0 20h24v4H0z"
                                                                />
                                                                <path
                                                                    style="
                                                                        fill: #000;
                                                                    "
                                                                    d="M11 3L5.5 17h2.25l1.12-3h6.25l1.12 3h2.25L13 3h-2zm-1.38 9L12 5.67 14.38 12H9.62z"
                                                                />
                                                            </svg>
                                                        </verte>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Empresa</label
                                        >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Nombre</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .empresa
                                                                    .nombre.show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="nombre"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="nombre"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Direccion</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .empresa
                                                                    .direccion
                                                                    .show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="direccionEmpresa"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="direccionEmpresa"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Email</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .empresa
                                                                    .email.show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="email"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="email"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Telefono</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .empresa
                                                                    .phone.show
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="phone"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="phone"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <label
                                            for=""
                                            class="
                                                font-weight-bold
                                                text-uppercase
                                            "
                                            >Detalle Tabla</label
                                        >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input
                                                    type="radio"
                                                    name="imagenAlign"
                                                    value="striped"
                                                    v-model="
                                                        json[0].Recibo.table
                                                            .tipo
                                                    "
                                                />
                                                <label>striped</label>
                                                <br />
                                                <input
                                                    type="radio"
                                                    name="imagenAlign"
                                                    value="normal"
                                                    v-model="
                                                        json[0].Recibo.table
                                                            .tipo
                                                    "
                                                />
                                                <label>Normal</label>
                                                <br />
                                            </div>
                                            <div class="col-md-6">
                                                <div class="switch">
                                                    <label
                                                        for=""
                                                        class="required"
                                                        >Border</label
                                                    >
                                                    <div class="onoffswitch">
                                                        <input
                                                            type="checkbox"
                                                            v-model="
                                                                json[0].Recibo
                                                                    .table.border
                                                            "
                                                            class="
                                                                onoffswitch-checkbox
                                                            "
                                                            id="border"
                                                        />
                                                        <label
                                                            class="
                                                                onoffswitch-label
                                                            "
                                                            for="border"
                                                        >
                                                            <span
                                                                class="
                                                                    onoffswitch-inner
                                                                "
                                                            ></span>
                                                            <span
                                                                class="
                                                                    onoffswitch-switch
                                                                "
                                                            ></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div
                                style="position: absolute; right: 0; bottom: 0"
                            >
                                <button
                                    class="btn btn-white"
                                    @click="vistaPdfEdit"
                                >
                                    <i class="fa fa-eye"></i>Vista Previa
                                </button>
                                <button
                                    class="btn btn-white"
                                    @click="updatePdfEdit"
                                >
                                    <i class="fa fa-plus"></i>Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["json"],
    data() {
        return {
            previewPdf: false,
            src: "",
            tipo: "",
            // colors:{ r: 255, g: 0, b: 0 }
        };
    },
    methods: {
        setTipo(tipo) {
            this.tipo = tipo;
        },
        openModal() {
            var $this = this;
            $this.previewPdf = true;
            $this.src = route("tipoDocumento.vistaPreviaPdf", {
                arreglo: JSON.stringify($this.json),
                tipo: $this.tipo,
            });
            $("#modalRecibo").modal("show");
        },
        vistaPdfEdit: function () {
            var $this = this;
            console.clear();
            $this.src = route("tipoDocumento.vistaPreviaPdf", {
                arreglo: JSON.stringify($this.json),
                tipo: $this.tipo,
            });
        },
        updatePdfEdit:function () {
            var $this=this;
            axios.post(route("tipoDocumento.updatePdf", {
                arreglo: JSON.stringify($this.json),
                tipo: $this.tipo,
            })).then((value) => {
                if(value.data.success) {
                    $("#modalRecibo").modal("hide")
                    toastr.success("Exito",value.data.mensaje);
                }
                else{
                    toastr.error("Error",value.data.mensaje);
                }
            })
        }
    },
};
</script>
<style>
fieldset {
    border-radius: 5px;
    background: #eee;
    /* margin: 10px;*/
    padding: 2px 4px 4px 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    position: relative;
    border: 0.5px groove rgb(219, 95, 37);
}
.required:after {
    color: rgb(219, 95, 37);
    content: "*";
    display: inline;
    font-weight: bold;
}
</style>
