<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostAtencion\PostAtencion;
use App\Models\Atencion;
use Illuminate\Http\Request;
use App\Traits\HttpResponseHelper;
use Exception;

class AtencionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createAtencion(PostAtencion $request, int $idCita)

    {
        try {
            $data = $request->validated();
            $data['idCita'] = $idCita; 

            $atencion = Atencion::create($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Atención creada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al crear la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener todas las atenciones con sus relaciones.
     */
    public function showAllAtenciones()
    {
        try {
            $atenciones = Atencion::with(['cita', 'enfermedad'])->get();

            return HttpResponseHelper::make()
                ->successfulResponse('Atención obtenida correctamente', [$atenciones]) 
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las atenciones: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener una atención por su ID.
     */
    public function showAtencion(int $id)
    {
        try {
            $atencion = Atencion::with(['cita', 'enfermedad'])->findOrFail($id);

            return HttpResponseHelper::make()
            ->successfulResponse('Atención obtenida correctamente', [$atencion])
            ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Actualizar una atención existente.
     */
    public function updateAtencion(PostAtencion $request, int $id)
    {
        try {
            $atencion = Atencion::findOrFail($id);
            $atencion->update($request->validated());

            return HttpResponseHelper::make()
                ->successfulResponse('Atención obtenida correctamente', [$atencion])
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Eliminar una atención.
     */
    public function destroyAtencion(int $id)
    {
        try {
            $atencion = Atencion::findOrFail($id);
            $atencion->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Atención eliminada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar la atención: ' . $e->getMessage())
                ->send();
        }
    }
}
