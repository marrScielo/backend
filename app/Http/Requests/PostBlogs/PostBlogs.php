<?php

namespace App\Http\Requests\PostBlogs;

use Illuminate\Foundation\Http\FormRequest;

class PostBlogs extends FormRequest
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
            'idEspecialidad'   => 'required|exists:especialidades,idEspecialidad',
            'tema'     => 'required|string|min:20|max:200',
            'contenido'     => 'required|string|min:200',
            'imagen'        => 'required|string', 
            'idPsicologo'   => 'required|exists:psicologos,idPsicologo'
        ];
    }



    //mensajes oara validacion
    
    public function messages(): array
    {
        return [
            'idCategoria.required' => 'El campo categoría es obligatorio.',
            'idCategoria.exists' => 'La categoría seleccionada no existe.',
            'contenido.required' => 'El contenido es obligatorio.',
            'contenido.min' => 'El contenido debe tener al menos 10 caracteres.',
            'idPsicologo.required' => 'Debe especificar un psicólogo.',
            'idPsicologo.exists' => 'El psicólogo seleccionado no existe.'
        ];
    }
}
