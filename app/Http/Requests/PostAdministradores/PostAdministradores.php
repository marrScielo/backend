<?php

namespace App\Http\Requests\PostAdministradores;

use Illuminate\Foundation\Http\FormRequest;

class PostAdministradores extends FormRequest
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
            /*'nombre' =>'required|string|max:100',
            'apellido' => 'required|string|max:350',
            'fecha_nacimiento' => 'required|string|max:100',
            'imagen' => 'required|string|max:50',
            'email' => 'required|string|max:100',
            'password' => 'required|string|max:100',*/
        ];
    }
}