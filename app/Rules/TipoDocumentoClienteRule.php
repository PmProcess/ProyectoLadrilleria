<?php

namespace App\Rules;

use App\Models\Administracion\Cliente;
use App\Models\Configuracion\TipoDocumento;
use Illuminate\Contracts\Validation\Rule;

class TipoDocumentoClienteRule implements Rule
{
    public $tipoDocumento;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tipoDocumentoCliente = Cliente::findOrFail($value)->persona->tipo_documento;
        $tipoDocumento = TipoDocumento::findOrFail($this->tipoDocumento)->id;
        return $tipoDocumentoCliente == 'DNI' ? ($tipoDocumento == 2 ? false : true) : ($tipoDocumento == 1 ? false : true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El cliente no cumple con el tipo de documento';
    }
}
