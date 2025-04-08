<?php

namespace App\Http\Controllers\Prepaciente;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCita\PostCita;
use Illuminate\Http\Request;
use App\Models\PrePaciente;
use App\Http\Requests\PrePacienteRequest;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Exception;

class PrePacienteController extends Controller
{
    public function createPrePaciente(Request $request)
    {
        try {
            // Validar manualmente lo del pre paciente
            $prePacienteValidated = $request->validate([
                'nombre' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'correo' => 'required|email|unique:pre_pacientes,correo|max:150',
            ]);

            $prePaciente = PrePaciente::create($prePacienteValidated);
            $id = $prePaciente->idPrePaciente;

            // Validar lo de la cita
            $citaValidated = $request->validate([
                'idPsicologo' => 'required|exists:psicologos,idPsicologo',
                'fecha_cita' => 'required|date',
                'hora_cita' => 'required|date_format:H:i',
            ]);

            // Set defaults de la cita
            $citaData = array_merge($citaValidated, [
                'motivo_Consulta' => 'Primera cita gratis',
                'idPrePaciente' => $id,
                'duracion' => 60,
                'colores' => '#FFA500',
                'estado_Cita' => 'Pendiente',
                'idCanal' => 1,
                'idEtiqueta' => 3,
                'idTipoCita' => 2,
            ]);

            Cita::create($citaData);

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente y cita creados correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al crear el pre paciente: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener todos los pre pacientes.
     */
    public function showAllPrePacientes()
    {
        try {
            $prePacientes = PrePaciente::all();

            return HttpResponseHelper::make()
                ->successfulResponse('PrePacientes obtenidos correctamente', [$prePacientes]) 
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener los pre pacientes: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener un pre paciente por su ID.
     */
    public function showPrePaciente(int $id)
    {
        try {
            $prePaciente = PrePaciente::findOrFail($id);

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente obtenido correctamente', [$prePaciente])
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener el pre paciente: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Actualizar un pre paciente existente.
     */
    public function updatePrePaciente(PrePacienteRequest $request, int $id)
    {
        try {
            $prePaciente = PrePaciente::findOrFail($id);
            $prePaciente->update($request->validated());

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente actualizado correctamente', [$prePaciente])
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar el pre paciente: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Eliminar un pre paciente.
     */
    public function destroyPrePaciente(int $id)
    {
        try {
            $prePaciente = PrePaciente::findOrFail($id);
            $prePaciente->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente eliminado correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar el pre paciente: ' . $e->getMessage())
                ->send();
        }
    }
}
