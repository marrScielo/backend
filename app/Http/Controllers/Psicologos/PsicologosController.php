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

    public function showAllPsicologos(Psicologo $psicologo)
    {
        try {
            $psicologos = Psicologo::with(['especialidades', 'enfoques','users'])->get()
            ->map(function ($psicologo) {
                return [
                    'idPsicologo' => $psicologo->idPsicologo,
                    'nombre' => $psicologo->users->name,
                    'apellido' => $psicologo->users->apellido,
                    'pais' => $psicologo->pais,
                    'genero' => $psicologo->genero,
                    'experiencia' => $psicologo->experiencia,
                    'especialidades' => $psicologo->especialidades->pluck('nombre'), 
                    'enfoques' => $psicologo->enfoques->pluck('nombre')
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
}
