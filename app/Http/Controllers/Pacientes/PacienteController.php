<?php

namespace App\Http\Controllers\Pacientes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostPaciente\PostPaciente;
use App\Http\Requests\PostUser\PostUser;
use App\Models\Paciente;
use App\Models\Psicologo;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function createPaciente(PostPaciente $requestPaciente)
    {
        try{
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();
            
            if (!$psicologo) {
                return HttpResponseHelper::make()
                ->unauthorizedResponse('Solo los psicólogos pueden crear pacientes')
                ->send();
            }
            
            $pacienteData = $requestPaciente->all();
            $pacienteData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $pacienteData['fecha_nacimiento'])->format('Y-m-d');
            $pacienteData['idPsicologo'] = $psicologo->idPsicologo;
            $pacienteData['codigo'] = Paciente::generatePacienteCode(); 
            
            Paciente::create($pacienteData);

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente creado correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function updatePaciente(PostPaciente $requestPaciente, int $id)
    {
        try{
            $paciente = Paciente::findOrFail($id);
            $pacienteData = $requestPaciente->all();
            $pacienteData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $pacienteData['fecha_nacimiento'])->format('Y-m-d');
            $paciente->update($pacienteData);

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente actualizado correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function showPacientesByPsicologo()
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se tiene acceso como psicologo')
                    ->send();
            }

            $pacientes = Paciente::where('idPsicologo', $psicologo->idPsicologo)->get();

            $response = $pacientes->map(function ($paciente) {
                return [
                    'idPaciente' => $paciente->idPaciente,
                    'codigo' => $paciente->codigo,
                    'DNI' => $paciente->DNI,
                    'nombre' => $paciente->nombre . ' ' . $paciente->apellido,
                    'correo' => $paciente->email,
                    'celular' => $paciente->celular,
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Pacientes obtenidos correctamente', $response)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showPacienteById($id)
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se tiene acceso como psicólogo.')
                    ->send();
            }

            $paciente = Paciente::where('idPaciente', $id)
                ->where('idPsicologo', $psicologo->idPsicologo)
                ->first();

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente obtenido correctamente', $paciente->toArray())
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyPaciente(int $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente eliminado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar el blog: ' . $e->getMessage())
                ->send();
        }
    }
}
