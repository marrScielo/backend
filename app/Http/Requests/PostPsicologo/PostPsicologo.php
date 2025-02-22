<?php

namespace App\Http\Requests\PostPsicologo;

use Illuminate\Foundation\Http\FormRequest;

class PostPsicologo extends FormRequest
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
            'introduccion' => 'required|string|max:350',
            'pais' => 'required|string|max:100',
            'genero' => 'required|string|max:50',
            'experiencia' => 'required|integer',
            'especialidades' => 'required|array|min:1|max:3',
            'enfoques' => 'required|array|min:1|max:3',
            'horario' => 'required|array',
            'horario.*' => 'array',
            'horario.*.*' => 'array|size:2',
        ];
    }
}