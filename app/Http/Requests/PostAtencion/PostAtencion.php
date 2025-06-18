<?php

namespace App\Http\Requests\PostAtencion;

use Illuminate\Foundation\Http\FormRequest;

class PostAtencion extends FormRequest
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
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'observacion' => 'required|string',
            'ultimosObjetivos' => 'required|string',
            'idEnfermedad' => 'required|exists:enfermedades,idEnfermedad',
            'comentario' => 'sometimes|string',
            'documentosAdicionales' => 'sometimes|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Cambiar de string a file
            'fechaAtencion' => 'sometimes|date', // Cambiar de required a sometimes
        ];
    }
}
