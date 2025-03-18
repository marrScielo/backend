<?php
namespace App\Http\Requests\PostCita;

use Illuminate\Foundation\Http\FormRequest;

class PostCita extends FormRequest
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
            'idEtiqueta' => 'required|exists:etiquetas,idEtiqueta',
            'idTipoCita' => 'required|exists:tipo_citas,idTipoCita',
            'idCanal' => 'required|exists:canales,idCanal',
            'idPaciente' => 'required|exists:pacientes,idPaciente',
            'idPsicologo' => 'required|exists:psicologos,idPsicologo',
            'colores' => 'nullable|string',
            'fecha_cita' => 'required|date',
            'duracion' => 'required|integer',
            'hora_cita' => 'required|date_format:H:i:s',
            'motivo_Consulta' => 'nullable|string',
            'estado_Cita' => 'required|in:Pendiente,Confirmada,Cancelada'
        ];
    }
}
