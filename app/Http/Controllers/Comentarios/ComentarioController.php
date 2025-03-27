<?php

namespace App\Http\Controllers\Comentarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostComentario\PostComentario;
use App\Models\Comentario;
use App\Traits\HttpResponseHelper;

class ComentarioController extends Controller
{
    public function createComentario(PostComentario $request, int $id)
    {
        try {
            $data = $request->all();
            $data['idBlog'] = $id;
            Comentario::create($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Comentario creado correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showComentariosByBlog(int $id)
    {
        try {
            $comentarios = Comentario::where('idBlog', $id)->get();

            return HttpResponseHelper::make()
                ->successfulResponse('Comentarios obtenidos correctamente', $comentarios)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyComentario(int $id)
    {
        try {
            $comentario = Comentario::where('idComentario', $id)->firstOrFail();
            $comentario->delete();
    
            return HttpResponseHelper::make()
                ->successfulResponse('Comentario eliminado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar el comentario: ' . $e->getMessage())
                ->send();
        }
    }
}
