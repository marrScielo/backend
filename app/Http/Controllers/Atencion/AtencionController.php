<?php

namespace App\Http\Controllers\Atencion;

use App\Http\Controllers\Controller;
use App\Models\Atencion;
use Illuminate\Http\Request;
use App\Http\Requests\PostAtencion\PostAtencion;
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
    public function showAllAtencionesPaciente(int $id)
    {
        try {
            $atenciones = Atencion::with(['cita.paciente']) // cargamos la relación hasta el paciente
                ->whereHas('cita', function ($query) use ($id) {
                    $query->where('idPaciente', $id);
                })
                ->get()
                ->map(function ($atencion) {
                    return [
                        'hora_inicio' => $atencion->cita->hora_cita,
                        'nombre_completo' => $atencion->cita->paciente->nombre . ' ' . $atencion->cita->paciente->apellido,
                        'diagnostico' => $atencion->Diagnostico,
                    ];
                });
    
            return HttpResponseHelper::make()
                ->successfulResponse('Atenciones resumidas del paciente obtenidas correctamente', [$atenciones])
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las atenciones resumidas: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener una atención por su ID.
     */
    public function showAtencion(int $id)
    {
        try {
            $atencion = Atencion::with(['cita.paciente', 'enfermedad'])->findOrFail($id);
    
            $data = [
                'MotivoConsulta' => $atencion->MotivoConsulta,
                'FormaContacto' => $atencion->FormaContacto,
                'Diagnostico' => $atencion->Diagnostico,
                'Tratamiento' => $atencion->Tratamiento,
                'Observacion' => $atencion->Observacion,
                'UltimosObjetivos' => $atencion->UltimosObjetivos,
                'idEnfermedad' => $atencion->idEnfermedad,
                'Comentario' => $atencion->Comentario,
                'DocumentosAdicionales' => $atencion->DocumentosAdicionales,
                'FechaAtencion' => $atencion->FechaAtencion,
                'descripcion' => $atencion->descripcion,
                'codigo_paciente' => $atencion->cita?->paciente?->codigo,
                'paciente' => $atencion->cita?->paciente?->nombre . ' ' . $atencion->cita?->paciente?->apellido,
            ];
    
            return HttpResponseHelper::make()
                ->successfulResponse('Atención obtenida correctamente', [$data])
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
