<?php

namespace App\Http\Controllers\Contactos;


use App\Http\Controllers\Controller;
use App\Models\contactos;
use App\Http\Requests\PostContactos\PostContactos;
use App\Traits\HttpResponseHelper;

class ContactosController extends Controller
{

    public function createContact(PostContactos $request)
    {
        try{
            Contactos::create($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Contacto creado correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function showAllContact(Contactos $contactanos)
    {
        try {
            $contacts = Contactos::all();

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de contactos obtenida correctamente', $contacts)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los contactos: ' . $e->getMessage())
                ->send();
        }
    }

    public function update(PostContactos $request, Contactos $contactanos)
    {
        
    }


    public function destroy(Contactos $contactanos)
    {
        
    }
}
