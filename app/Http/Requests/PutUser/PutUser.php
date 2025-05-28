<?php

namespace App\Http\Requests\PutUser;

use App\Models\Psicologo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PutUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare data for validation: merge actual user_id based on psicólogo route param
     */
    protected function prepareForValidation()
    {
        if ($psicologo = Psicologo::find($this->route('id'))) {
            $this->merge(['user_id' => $psicologo->user_id]);
        }
    }

    /**
     * Validation rules for updating user data
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:100',
            'apellido' => 'sometimes|string|max:100',
            'email' => [
                'sometimes',
                'email',
                'max:254',
                // Ignore unique check on actual user_id column, not default 'id'
                Rule::unique('users', 'email')
                    ->ignore($this->input('user_id'), 'user_id'),
            ],
            'password' => 'sometimes|string|min:8|max:100',
            'fecha_nacimiento' => 'sometimes|date_format:d/m/Y',
            'imagen' => 'sometimes|string|nullable',
        ];
    }
}
