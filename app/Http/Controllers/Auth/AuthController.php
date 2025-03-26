<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PostAuth\PostAuth;
use App\Traits\HttpResponseHelper;

class AuthController extends Controller
{
    public function login(PostAuth $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return HttpResponseHelper::make()
                    ->unauthorizedResponse('El correo electrónico no está registrado.');
               
            }
            if (!Hash::check($request->password, $user->password)) {
                return HttpResponseHelper::make()
                    ->unauthorizedResponse('La contraseña es incorrecta.');
                   
            }
            $token = $user->createToken('token')->plainTextToken;

            return HttpResponseHelper::make()
                ->successfulResponse('Inicio de sesión exitoso.', [
                    'token' => $token,
                    'nombre' => $user->name,
                    'apellido' => $user->apellido,
                    'email' => $user->email,
                    'id' => $user->user_id,
                    'rol' => $user->rol
                ])
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()

                ->internalErrorResponse(
                    'Hubo un problema al procesar la solicitud.' .
                        $e->getMessage()
                )
                ->send();
        }
    }

    public function logout(PostAuth $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Cierre de sesion exitoso.')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Hubo un problema al procesar la solicitud. Por favor, intente nuevamente.')
                ->send();
        }
    }
}
