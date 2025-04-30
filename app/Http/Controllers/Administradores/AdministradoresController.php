<?php

namespace App\Http\Controllers\Administradores;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostAdministradores\PostAdministradores;
use App\Http\Requests\PostUser\PostUser;
use App\Http\Requests\PutAdministradores\PutAdministradores;
use App\Http\Requests\PutUser\PutUser;
use App\Models\Administradores;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class AdministradoresController extends Controller
{
    

    public function createAdministradores(PostAdministradores $requestAdministradores, PostUser $requestUser)
    {
        DB::beginTransaction();
        try {
            // Validar y preparar datos del usuario
            $usuarioData = $requestUser->validated();
            $usuarioData['rol'] = 'ADMIN';
            $usuarioData['fecha_nacimiento'] = Carbon::createFromFormat('d/m/Y', $usuarioData['fecha_nacimiento'])
                ->format('Y-m-d');
            $usuarioData['password'] = Hash::make($requestUser['password']);

            // Crear usuario
            $usuario = User::create($usuarioData);
            
            // Crear administrador asociado
            $administradorData = $requestAdministradores->validated();
            $administradorData['user_id'] = $usuario->user_id;
            $administrador = Administradores::create($administradorData);

            // Asignar rol
            $usuario->assignRole('ADMIN');

            DB::commit();

            return HttpResponseHelper::make()
            ->successfulResponse('Administrador creado correctamente')->send();

        } catch (\Exception $e) {
            DB::rollBack();
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al crear administrador: ' . $e->getMessage())->send();
        }
    }

    public function showById(int $id)
    {
        try {
            $administrador = Administradores::with(['user'])->find($id);

            if (!$administrador) {
                return HttpResponseHelper::make()
                ->notFoundResponse('Administrador no encontrado')->send();
            }

            if (!$administrador->user) {
                return HttpResponseHelper::make()
                ->notFoundResponse('Usuario asociado al administrador no encontrado')->send();
            }

            $response = [
                'idAdministrador' => $administrador->idAdmin,
                'nombre' => $administrador->user->name,
                'apellido' => $administrador->user->apellido,
                'email' => $administrador->user->email,
                'imagen' => $administrador->user->imagen,
                'fecha_nacimiento' => $administrador->user->fecha_nacimiento 
                    ? Carbon::parse($administrador->user->fecha_nacimiento)->format('d/m/Y')
                    : null,
                'estado' => $administrador->estado,
                'creado_en' => $administrador->created_at 
                    ? $administrador->created_at->format('d/m/Y H:i:s') 
                    : null
            ];

            return HttpResponseHelper::make()
            ->successfulResponse('Administrador obtenido correctamente', $response)->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al obtener administrador: ' . $e->getMessage())->send();
        }
    }

    public function showAllAdministradores()
    {
        try {
            $administradores = Administradores::with(['user'])
                ->where('estado', 'A')
                ->get()
                ->map(function ($admin) {
                    if (!$admin->user) {
                        return null;
                    }
                    
                    return [
                        'idAdministrador' => $admin->idAdmin,
                        'nombre' => $admin->user->name,
                        'apellido' => $admin->user->apellido,
                        'email' => $admin->user->email,
                        'imagen' => $admin->user->imagen,
                        'estado' => $admin->estado,
                        'ultima_actualizacion' => $admin->updated_at 
                            ? $admin->updated_at->format('d/m/Y H:i') 
                            : null
                    ];
                })
                ->filter();

            return HttpResponseHelper::make()
            ->successfulResponse('Lista de administradores obtenida', $administradores)->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al obtener administradores: ' . $e->getMessage())->send();
        }
    }

    public function updateAdministradores(PutAdministradores $requestAdministradores, PutUser $requestUser, int $id)
    {
        DB::beginTransaction();
        try {
            $administrador = Administradores::findOrFail($id);
            $usuario = User::findOrFail($administrador->user_id);

            // Actualizar datos de administrador
            $adminData = $requestAdministradores->validated();
            $administrador->update($adminData);

            // Actualizar datos de usuario
            $userData = $requestUser->validated();
            
            if ($requestUser->filled('password')) {
                $userData['password'] = Hash::make($requestUser->password);
            }
            
            if ($requestUser->filled('fecha_nacimiento')) {
                $userData['fecha_nacimiento'] = Carbon::createFromFormat('d/m/Y', $requestUser->fecha_nacimiento)
                    ->format('Y-m-d');
            }
            
            $usuario->update($userData);

            DB::commit();

            return HttpResponseHelper::make()
            ->successfulResponse('Administrador actualizado correctamente')->send();

        } catch (\Exception $e) {
            DB::rollBack();
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al actualizar: ' . $e->getMessage())->send();
        }
    }

    public function cambiarEstadoAdministrador(int $id)
    {
        try {
            $administrador = Administradores::find($id);

            if (!$administrador) {
                return HttpResponseHelper::make()
                ->notFoundResponse('Administrador no encontrado')->send();
            }

            $nuevoEstado = $administrador->estado === 'A' ? 'I' : 'A';
            $administrador->estado = $nuevoEstado;
            $administrador->save();

            return HttpResponseHelper::make()
            ->successfulResponse(
                'Estado cambiado a ' . ($nuevoEstado === 'A' ? 'Activo' : 'Inactivo')
            )->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al cambiar estado: ' . $e->getMessage())->send();
        }
    }

    public function deleteAdministrador(int $id)
    {
        DB::beginTransaction();
        try {
            $administrador = Administradores::find($id);
            
            if (!$administrador) {
                return HttpResponseHelper::make()
                ->notFoundResponse('Administrador no encontrado')->send();
            }

            $userId = $administrador->user_id;
            $administrador->delete();
            
            if ($userId) {
                User::find($userId)->delete();
            }

            DB::commit();

            return HttpResponseHelper::make()
            ->successfulResponse('Administrador eliminado correctamente')->send();

        } catch (\Exception $e) {
            DB::rollBack();
            return HttpResponseHelper::make()
            ->internalErrorResponse('Error al eliminar: ' . $e->getMessage())->send();
        }
    }
}