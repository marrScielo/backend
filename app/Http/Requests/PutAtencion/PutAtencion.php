<?php

namespace App\Http\Requests\PutAtencion;

use Illuminate\Foundation\Http\FormRequest;

class PutAtencion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'diagnostico' => 'sometimes|string|max:1000',
            'tratamiento' => 'sometimes|string|max:1000',
            'observacion' => 'sometimes|string|max:1000',
            'ultimosObjetivos' => 'sometimes|string|max:1000',
            'idEnfermedad' => 'sometimes|integer|exists:enfermedades,idEnfermedad',
            'fechaAtencion' => 'sometimes|date',
            'comentario' => 'sometimes|string|max:1000',
            'documentosAdicionales' => 'sometimes|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB máximo
        ];
    }

    public function messages()
    {
        return [
            'documentosAdicionales.file' => 'El documento debe ser un archivo válido.',
            'documentosAdicionales.mimes' => 'El documento debe ser un archivo de tipo: pdf, doc, docx, jpg, jpeg, png.',
            'documentosAdicionales.max' => 'El documento no debe ser mayor a 10MB.',
            'idEnfermedad.exists' => 'La enfermedad seleccionada no existe.',
        ];
    }
}