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
    public function createPrePaciente(PrePacienteRequest $PacienteRequest, PostCita $CitaRequest)
    {
        try {
            $data = $PacienteRequest->validated();
            $prePaciente = PrePaciente::create($data);
            $id = $prePaciente->idPrepaciente;

            $citaData = $CitaRequest->validated();
            $citaData['motivo_Consulta'] = 'Primera cita gratis';
            $citaData['idPrepaciente'] = $id;
            $cita = Cita::create($citaData);

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente creado correctamente')
                ->send();
        } catch (Exception $e) {
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
