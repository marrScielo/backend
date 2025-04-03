<?php

namespace App\Http\Requests\PostRegistroFamiliar;

use Illuminate\Foundation\Http\FormRequest;

class PostRegistroFamiliar extends FormRequest
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
            'nombre_madre' => 'nullable|string|max:250',
            'estado_madre' => 'required|string|max:250',
            'nombre_padre' => 'nullable|string|max:250',
            'estado_padre' => 'required|string|max:250',
            'nombre_apoderado' => 'nullable|string|max:250',
            'estado_apoderado' => 'nullable|string|max:250',
            'cantidad_hijos' => 'required|integer|min:0',
            'cantidad_hermanos' => 'required|integer|min:0',
            'integracion_familiar' => 'required|string|max:450',
            'historial_familiar' => 'required|string|max:400',
        ];
    }
}
