<?php

namespace App\Http\Controllers\Contactos;


use App\Http\Controllers\Controller;
use App\Models\contactos;
use App\Http\Requests\PostContactos\PostContactos;
use App\Traits\HttpResponseHelper;
use App\Mail\ContactoMailable;
use Illuminate\Support\Facades\Mail;

class ContactosController extends Controller
{

    public function createContact(PostContactos $request)
    {
        try {
            
            $contacto = Contactos::create($request->all());
    
            $datos = [
                'nombre' => $contacto->nombre,
                'apellido' => $contacto->apellido,
                'celular' => $contacto->celular,
                'email' => $contacto->email,
                'comentario' => $contacto->comentario
            ];
    
            $adminEmail = config('mail.admin_address', 'contigovoyproject@gmail.com'); // Usa config en lugar de env()
            Mail::to($adminEmail)->send(new ContactoMailable($datos));
    
            return HttpResponseHelper::make()
                ->successfulResponse('Contacto creado correctamente y correo enviado.')
                ->send();
    
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
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
