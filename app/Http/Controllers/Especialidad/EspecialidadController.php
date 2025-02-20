<?php

namespace App\Http\Controllers\Especialidad;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use App\Traits\HttpResponseHelper;

class EspecialidadController extends Controller
{
    public function create()
    {
        try {
            Especialidad::create(request()->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Especialidad creada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showAll()
    {
        try {
            $especialidades = Especialidad::all();

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de especialidades obtenida correctamente', $especialidades)
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener las especialidades: ' . $e->getMessage())
                ->send();
        }
    }

    public function update(Especialidad $especialidad)
    {
        try {
            $especialidad->update(request()->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Especialidad actualizada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la especialidad: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroy(Especialidad $especialidad)
    {
        try {
            $especialidad->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Especialidad eliminada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar la especialidad: ' . $e->getMessage())
                ->send();
        }
    }
}
