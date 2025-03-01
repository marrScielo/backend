<?php

namespace App\Http\Controllers\Pacientes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostPaciente\PostPaciente;
use App\Http\Requests\PostUser\PostUser;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;

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

            // Asignar el user_id recién creado al paciente
            $pacienteData = $requestPaciente->all();
            $pacienteData['user_id'] = $usuario_id;
            $paciente = Paciente::create($pacienteData);

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

    

}
