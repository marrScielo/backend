<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrePacienteRequest extends FormRequest
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
            'nombre' => 'required|string|max:150',
            'celular' => 'required|string|min:9|max:9',
            'correo' => 'required|email|unique:pre_pacientes,correo|max:150',
            'fecha' => 'required|date',         
            'hora' => 'required|string',        
            'idPsicologo' => 'required|integer' 
        ];
    }
}
