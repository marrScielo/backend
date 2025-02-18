<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUser\PostUser;
use App\Traits\HttpResponseHelper;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function register(PostUser $request)
    {
        try{
            $userData = $request->all();
            $userData['password'] = Hash::make($request['password']);

            $user = User::create($userData);

            $user->assignRole('USER');

            return HttpResponseHelper::make()
                ->successfulResponse('Usuario creado correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }
}
