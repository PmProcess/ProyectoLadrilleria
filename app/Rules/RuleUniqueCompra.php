<?php

namespace App\Rules;

use App\Models\Compras\DocumentoCompra;
use App\Models\Configuracion\TipoDocumento;
use Illuminate\Contracts\Validation\Rule;

class RuleUniqueCompra implements Rule
{
    public $tipo_documento;
    public $vista;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tipo_documento, $vista = 'create', $id = null)
    {
        $this->tipo_documento = $tipo_documento;
        $this->vista = $vista;
        $this->id = $id;
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
        if (!str_contains($value, '-')) {
            return false;
        }
        $numeracion = explode('-', $value)[0];
        if (str_contains($numeracion, TipoDocumento::findOrFail($this->tipo_documento)->tipo == 'Boleta de Venta' ? 'B' : 'F')) {
            $consulta = DocumentoCompra::where('numeracion', $value)->where('estado', '!=', 'ANULADO');
            $consulta = $this->vista == 'create' ? $consulta : $consulta->where('id', '!=', $this->id);
            return $consulta->count() == 0 ? true : false;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La Numeracion es Incorrecta';
    }
}
