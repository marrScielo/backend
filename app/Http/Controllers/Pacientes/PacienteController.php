<?php

namespace App\Http\Controllers\Pacientes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostPaciente\PostPaciente;
use App\Http\Requests\PostUser\PostUser;
use App\Models\Paciente;
use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function createPaciente(PostPaciente $requestPaciente, PostUser $requestUser)
    {
        try{
            $usuarioData = $requestUser->all();
            $usuarioData['rol'] = 'PACIENTE';
            $usuarioData['password'] = Hash::make($requestUser['password']);
            $usuarioData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $usuarioData['fecha_nacimiento'])->format('Y-m-d');
            $usuario = User::create($usuarioData);
            $usuario_id = $usuario->user_id;

            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->unauthorizedResponse('Solo los psicólogos pueden crear pacientes')
                    ->send();
            }
            
            $pacienteData = $requestPaciente->all();
            $pacienteData['idPsicologo'] = $psicologo->idPsicologo;
            
            // Asignar el user_id recién creado al paciente
            $pacienteData['user_id'] = $usuario_id;
            Paciente::create($pacienteData);

            $usuario->assignRole('PACIENTE');

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

    public function updatePaciente(PostPaciente $requestPaciente, PostUser $requestUser, int $id)
    {
        try{
            $paciente = Paciente::findOrFail($id);
            $pacienteData = $requestPaciente->all();
            $paciente->update($pacienteData);
            
            $usuario= User::findOrFail($paciente->user_id);
            $usuarioData = $requestUser->all();
            $usuarioData['password'] = Hash::make($requestUser['password']);
            $usuarioData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $usuarioData['fecha_nacimiento'])->format('Y-m-d');
            $usuario->update($usuarioData);

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
            $idPsicologo = $psicologo->idPsicologo;

            $psicologos = Paciente::where('idPsicologo', $idPsicologo)->get();

            return HttpResponseHelper::make()
                ->successfulResponse('Pacientes obtenidos correctamente', $psicologos)
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
