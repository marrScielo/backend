<?php

namespace App\Http\Requests\PutPaciente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PutPaciente extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // ignoramos el propio registro para la regla unique
        $id = $this->route('id');

        return [
            'nombre'           => 'sometimes|string|max:100',
            'apellido'         => 'sometimes|string|max:100',
            'email'            => [
                'sometimes',
                'email',
                'max:100',
                Rule::unique('pacientes','email')->ignore($id,'idPaciente'),
            ],
            'fecha_nacimiento' => 'sometimes|date_format:Y-m-d',
            'ocupacion'        => 'sometimes|string|max:100',
            'estadoCivil'      => 'sometimes|string|max:100',
            'genero'           => 'sometimes|string|max:20',
            'DNI'              => 'sometimes|string',
            'celular'          => 'sometimes|string|size:9',
            'direccion'        => 'sometimes|string|max:150',
        ];
    }
}
