const { default: axios } = require("axios");
export default {
    verificarExistenciaTipoEmpleado()
    {
        return axios.get(route('tipoempleado.verify'));
    },
    obtenerArreglo()
    {
        return axios.get(route('tipoDocumento.formatoPdf'));
    }
}
