<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtencionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'MotivoConsulta' => 'nullable|string|max:255',
            'FormaContacto' => 'nullable|string|max:100',
            'Diagnostico' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Observacion' => 'nullable|string',
            'UltimosObjetivos' => 'nullable|string',
            'idEnfermedad' => 'nullable|exists:enfermedades,idEnfermedad',
            'Comentario' => 'nullable|string',
            'DocumentosAdicionales' => 'nullable|string',
            'FechaAtencion' => 'required|date',
            'descripcion' => 'nullable|string',
        ];
    }
}
