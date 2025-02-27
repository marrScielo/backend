<?php

namespace App\Http\Controllers\Psicologos;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUser\PostUser;
use App\Http\Requests\PostPsicologo\PostPsicologo;
use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponseHelper;

class PsicologosController extends Controller
{
    
    public function createPsicologo(PostPsicologo $requestPsicologo, PostUser $requestUser)
    {
        try{
            $usuarioData = $requestUser->all();
            $usuarioData['rol'] = 'PSICOLOGO';
            $usuarioData['password'] = Hash::make($requestUser['password']);
            $usuario = User::create($usuarioData);
            $usuario_id = $usuario->user_id;

            // Asignar el user_id recién creado al psicologo
            $psicologoData = $requestPsicologo->all();
            $psicologoData['user_id'] = $usuario_id;
            $psicologo = Psicologo::create($psicologoData);

            // Asociar las especialidades y enfoques al psicólogo
            $psicologo->especialidades()->attach($requestPsicologo->input('especialidades'));
            $psicologo->enfoques()->attach($requestPsicologo->input('enfoques'));

            $usuario->assignRole('PSICOLOGO');

            return HttpResponseHelper::make()
                ->successfulResponse('Psicologo creado correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function showById(int $id)
    {
        try {
            $psicologo = Psicologo::with(['especialidades', 'enfoques', 'users'])->find($id);

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
                'enfoques' => $psicologo->enfoques->pluck('nombre'),
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
            $psicologos = Psicologo::with(['especialidades', 'enfoques','users'])
            ->where('estado', 'A') // Mostrar solo psicólogos activos
            ->get()
            ->map(function ($psicologo) {
                return [
                    'idPsicologo' => $psicologo->idPsicologo,
                    'nombre' => $psicologo->users->name,
                    'apellido' => $psicologo->users->apellido,
                    'pais' => $psicologo->pais,
                    'genero' => $psicologo->genero,
                    'experiencia' => $psicologo->experiencia,
                    'especialidades' => $psicologo->especialidades->pluck('nombre'), 
                    'enfoques' => $psicologo->enfoques->pluck('nombre'),
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de psicologos obtenida correctamente', $psicologos)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los contactos: ' . $e->getMessage())
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
            $usuario->update($usuarioData);

            // Asociar las nuevas especialidades y enfoques al psicólogo
            $psicologo->especialidades()->sync($requestPsicologo->input('especialidades'));
            $psicologo->enfoques()->sync($requestPsicologo->input('enfoques'));

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
