<?php

namespace App\Http\Controllers\Psicologos;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUser\PostUser;
use App\Http\Requests\PostPsicologo\PostPsicologo;
use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;

class PsicologosController extends Controller
{
    
    public function createPsicologo(PostPsicologo $requestPsicologo, PostUser $requestUser)
    {
        try {
            $usuarioData = $requestUser->all();
            $usuarioData['rol'] = 'PSICOLOGO';
            $usuarioData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $usuarioData['fecha_nacimiento'])
                ->format('Y-m-d');
            $usuarioData['password'] = Hash::make($requestUser['password']);

            $usuario = User::create($usuarioData);
            $usuario_id = $usuario->user_id;
    
            // Asignar el user_id recién creado al psicólogo
            $psicologoData = $requestPsicologo->all();
            $psicologoData['user_id'] = $usuario_id;
            $psicologo = Psicologo::create($psicologoData);
    
            // Asociar las especialidades y enfoques al psicólogo
            $psicologo->especialidades()->attach($requestPsicologo->input('especialidades'));
    
            $usuario->assignRole('PSICOLOGO');
    
            return HttpResponseHelper::make()
                ->successfulResponse('Psicólogo creado correctamente')
                ->send();
    
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showById(int $id)
    {
        try {
            $psicologo = Psicologo::with(['especialidades', 'users'])->find($id);

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se encontró un psicólogo con el ID proporcionado.')
                    ->send();
            }

            $response = [
                'idPsicologo' => $psicologo->idPsicologo,
                'nombre' => $psicologo->users->name,
                'apellido' => $psicologo->users->apellido,
                'especialidades' => $psicologo->especialidades->pluck('nombre'),
                'introduccion' => $psicologo->introduccion,
                'horario' => $psicologo->horario,
            ];

            return HttpResponseHelper::make()
                ->successfulResponse('Psicólogos obtenidos correctamente', $response)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener el psicólogo: ' . $e->getMessage())
                ->send();
        }
    }

    public function showAllPsicologos(Psicologo $psicologo)
    {
        try {
            $psicologos = Psicologo::with(['especialidades','users'])
            ->where('estado', 'A')
            ->get()
            ->map(function ($psicologo) {
                return [
                    'idPsicologo' => $psicologo->idPsicologo,
                    'nombre' => $psicologo->users->name,
                    'apellido' => $psicologo->users->apellido,
                    'pais' => $psicologo->pais,
                    'edad' => $psicologo->users->edad,
                    'genero' => $psicologo->genero,
                    'experiencia' => $psicologo->experiencia,
                    'especialidades' => $psicologo->especialidades->pluck('nombre'), 
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de psicologos obtenida correctamente', $psicologos)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los psicologos: ' . $e->getMessage())
                ->send();
        }
    }

    public function updatePsicologo(PostPsicologo $requestPsicologo, PostUser $requestUser, int $id)
    {
        try{
            $psicologo = Psicologo::findOrFail($id);
            $psicologoData = $requestPsicologo->all();
            $psicologo->update($psicologoData);
            
            $usuario= User::findOrFail($psicologo->user_id);
            $usuarioData = $requestUser->all();
            $usuarioData['password'] = Hash::make($requestUser['password']);
            $usuarioData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $usuarioData['fecha_nacimiento'])->format('Y-m-d');

            $usuario->update($usuarioData);

            // Asociar las nuevas especialidades al psicólogo
            $psicologo->especialidades()->sync($requestPsicologo->input('especialidades'));

            return HttpResponseHelper::make()
                ->successfulResponse('Psicologo actualizado correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function desactivatePsicologo(int $id)
    {
        try {
            $psicologo = Psicologo::find($id);

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se encontró un psicólogo con el ID proporcionado.')
                    ->send();
            }

            // Cambiar el estado a desactivado 
            $psicologo->estado = 'I';
            $psicologo->save();

            return HttpResponseHelper::make()
                ->successfulResponse('Psicólogo desactivado correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al desactivar el psicólogo: ' . $e->getMessage())
                ->send();
        }
    }
}
