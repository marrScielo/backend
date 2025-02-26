<?php

namespace App\Http\Requests\PostPaciente;

use Illuminate\Foundation\Http\FormRequest;

class PostPaciente extends FormRequest
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
            'ocupacion' => 'required|string|max:100',
            'estadoCivil' => 'required|string|max:100',
            'genero' => 'required|string|max:20',
            'DNI' => 'required|string',
            'celular' => 'required|string|min:9|max:9',
            'direccion' => 'required|string|max:150'
        ];
    }
}