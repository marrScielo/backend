<?php

namespace App\Http\Controllers\RespuestasBlog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Traits\HttpResponseHelper;
use App\Http\Requests\RespuestaComentarioRequest;
use Exception;

class RespuestaComentarioController extends Controller
{
    public function createRespuesta(RespuestaComentarioRequest $request)
    {
        try {
            $data = $request->validated();
            $respuesta = Respuesta::create($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Respuesta creada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al crear la respuesta: ' . $e->getMessage())
                ->send();
        }
    }

    public function showAllRespuestas()
    {
        try {
            $respuestas = Respuesta::with(['comentario', 'usuario'])->get();
            return HttpResponseHelper::make()
                ->successfulResponse('Lista de respuestas obtenida correctamente', $respuestas)
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las respuestas: ' . $e->getMessage())
                ->send();
        }
    }

    public function showRespuesta(int $id)
    {
        try {
            $respuesta = Respuesta::with(['comentario', 'usuario'])->find($id);

            if (!$respuesta) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('Respuesta no encontrada')
                    ->send();
            }

            return HttpResponseHelper::make()
                ->successfulResponse('Respuesta obtenida correctamente', $respuesta->toArray())
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la respuesta: ' . $e->getMessage())
                ->send();
        }
    }

    public function updateRespuesta(RespuestaComentarioRequest $request, int $id)
    {
        try {
            $respuesta = Respuesta::findOrFail($id);
            $respuesta->update($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Respuesta actualizada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la respuesta: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyRespuesta(int $id)
    {
        try {
            $respuesta = Respuesta::findOrFail($id);
            $respuesta->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Respuesta eliminada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar la respuesta: ' . $e->getMessage())
                ->send();
        }
    }
}
