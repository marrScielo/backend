<?php

namespace App\Http\Controllers\Prepaciente;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCita\PostCita;
use Illuminate\Http\Request;
use App\Models\PrePaciente;
use App\Http\Requests\PrePacienteRequest;
use App\Mail\PrePacienteCreado;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Models\User;


class PrePacienteController extends Controller
{
    public function createPrePaciente(PrePacienteRequest  $request)
    {
        try {

            $prePaciente = PrePaciente::create($request->all());

            // Cargamos la relación con el psicólogo
            $prePaciente->load('psicologo');

            $datos = [
                'nombre'  => $prePaciente->nombre,
                'celular' => $prePaciente->celular,
                'correo'  => $prePaciente->correo,
                'estado'  => $prePaciente->estado
            ];

            
            $adminEmail = config('emails.admin_address', 'contigovoyproject@gmail.com');
            
            Mail::to($adminEmail)->send(new PrePacienteCreado($datos));

            Mail::to($prePaciente->correo)->send(new \App\Mail\ConfirmacionPrePaciente([
                'nombre' => $prePaciente->nombre,
                'fecha'  => $request->input('fecha'),
                'hora'   => $request->input('hora'),
                'psicologo' => $prePaciente->psicologo
                ? $prePaciente->psicologo->name . ' ' . $prePaciente->psicologo->apellido
                : 'No disponible',
 
            ]));

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente creado correctamente y correo enviado.')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud: ' . $e->getMessage())
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

            return view('pre_pacientes', ['prePacientes' => $prePacientes]);

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
