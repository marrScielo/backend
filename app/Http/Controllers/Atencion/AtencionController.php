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
     * Obtener todas las atenciones 
     */
    public function showAllAtenciones()
    {
        try {
            $atenciones = Atencion::with(['cita.paciente', 'cita.prepaciente'])
                ->get()
                ->map(function ($atencion) {
                    $cita = $atencion->cita;

                    // Buscar nombre de paciente o prepaciente
                    if ($cita->paciente) {
                        $nombre = $cita->paciente->nombre . ' ' . $cita->paciente->apellido;
                    } elseif ($cita->prepaciente) {
                        $nombre = $cita->prepaciente->nombre . ' ' . $cita->prepaciente->apellido;
                    } else {
                        $nombre = 'Nombre no disponible';
                    }

                    return [
                        'hora_inicio' => $cita->hora_cita,
                        'nombre_completo' => $nombre,
                        'diagnostico' => $atencion->Diagnostico,
                        'fecha_inicio' => $atencion->FechaAtencion,
                        'idCita' => $cita->idCita,
                        'idAtencion' => $atencion->IdAtencion,
                        'idPaciente' => $atencion->cita->idPaciente,
                    ];
                });

            return HttpResponseHelper::make()
                ->successfulResponse('Todas las atenciones obtenidas correctamente', [$atenciones])
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
    public function showAllAtencionesPaciente(int $id)
    {
        try {
            $atenciones = Atencion::with(['cita.paciente', 'cita.prepaciente']) // Cargamos ambas relaciones
                ->whereHas('cita', function ($query) use ($id) {
                    $query->where('idPaciente', $id); // Solo filtra por paciente
                })
                ->get()
                ->map(function ($atencion) {
                    $cita = $atencion->cita;
    
                    // Si existe paciente, lo usamos. Si no, buscamos el prepaciente.
                    if ($cita->paciente) {
                        $nombre = $cita->paciente->nombre . ' ' . $cita->paciente->apellido;
                    } elseif ($cita->prepaciente) {
                        $nombre = $cita->prepaciente->nombre . ' ' . $cita->prepaciente->apellido;
                    } else {
                        $nombre = 'Nombre no disponible';
                    }
    
                    return [
                        'hora_inicio' => $cita->hora_cita,
                        'nombre_completo' => $nombre,
                        'diagnostico' => $atencion->Diagnostico,
                        'fecha_inicio' => $atencion->FechaAtencion,
                        'idCita' => $cita->idCita,
                        'idAtencion' => $atencion->IdAtencion
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
