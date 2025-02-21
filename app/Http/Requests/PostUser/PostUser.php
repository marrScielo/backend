<?php

namespace App\Http\Requests\PostUser;

use Illuminate\Foundation\Http\FormRequest;

class PostUser extends FormRequest
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
            'name' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'edad' => 'required|integer',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|min:8|max:100',
            'fecha_nacimiento' => 'required|date',
            'fecha_creacion' => 'date',
            'imagen' => 'required|string|max:100',
        ];
    }
}