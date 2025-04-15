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
    public function createPrePaciente(Request $request)
    {
        try {

            $prePacienteValidated = $request->validate([
                'nombre' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'correo' => 'required|email|unique:pre_pacientes,correo|max:150',
                'idPsicologo' => 'required|exists:psicologos,idPsicologo',
            ]);

            $prePaciente = PrePaciente::create($prePacienteValidated);
            $id = $prePaciente->idPrePaciente;

            // Validar cita
            $citaValidated = $request->validate([
                'idPsicologo' => 'required|exists:psicologos,idPsicologo',
                'fecha_cita' => 'required|date',
                'hora_cita' => 'required|date_format:H:i',
            ]);

            // Set defaults de la cita
            $citaData = array_merge($citaValidated, [
                'motivo_Consulta' => 'Primera cita gratis',
                'idPrePaciente' => $id,
            ]);

            Cita::create($citaData);

            // Cargamos la relación con el psicólogo
            $prePaciente = PrePaciente::with('psicologo.users')->find($id);

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
                'fecha'  => $request->input('fecha_cita'),
                'hora'   => $request->input('hora_cita'),
                'psicologo' => (
                    $prePaciente->psicologo && $prePaciente->psicologo->users
                        ? $prePaciente->psicologo->users->name . ' ' . $prePaciente->psicologo->users->apellido
                        : 'No disponible'
                ),
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
    public function updatePrePaciente(Request $request, int $id)
    {
        try {
            $prePaciente = PrePaciente::findOrFail($id);
            $prePaciente->update($request->validated([
                'nombre' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'correo' => 'required|email|unique:pre_pacientes,correo|max:150',
            ]));

            return HttpResponseHelper::make()
                ->successfulResponse('PrePaciente actualizado correctamente')
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
