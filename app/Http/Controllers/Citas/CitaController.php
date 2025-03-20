<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Illuminate\Http\Request;
use App\Http\Requests\PostCita\PostCita;
use Exception;


class CitaController extends Controller
{
    
    public function createCita(PostCita $request)
    {
        try {
            $data = $request->validated();
            $cita = Cita::create($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Cita creada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al crear la cita: ' . $e->getMessage())
                ->send();
        }
    }

    public function showAllCitasByPsicologo()
    {
        try {
            $citas = Cita::with(['paciente'])
            ->get()
            ->map(function ($cita) {
                return [
                    'idCita' => $cita->idCita,
                    'paciente' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido,
                    'motivo' => $cita->motivo_Consulta,
                    'estado' => $cita->estado_Cita,
                    'fecha_inicio' => $cita->fecha_cita . ' ' . $cita->hora_cita,
                    'duracion' => $cita->duracion . ' min.',
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de citas obtenida correctamente', $citas)
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las citas: ' . $e->getMessage())
                ->send();
        }
    }

    public function showCitaById(int $id)
    {
        try {
            $cita = Cita::with(['etiqueta', 'tipoCita', 'canal', 'paciente'])->find($id)
            ->get()
            ->map(function ($cita) {
                return [
                    'idCita' => $cita->idCita,
                    'paciente' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido,
                    'motivo' => $cita->motivo_Consulta,
                    'estado' => $cita->estado_Cita,
                    'color' => $cita->color,
                    'fecha' => $cita->fecha_cita,
                    'hora' => $cita->hora_cita,
                    'tipo_cita' => $cita->tipoCita->nombre,
                    'duracion' => $cita->duracion . 'min.',
                    'canal' => $cita->canal->nombre,
                    'etiqueta' => $cita->etiqueta->nombre,
                ];
            });

            if (!$cita) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('Cita no encontrada')
                    ->send();
            }

            return HttpResponseHelper::make()
            ->successfulResponse('Cita obtenida correctamente', $cita->toArray())
            ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la cita: ' . $e->getMessage())
                ->send();
        }
    }

    public function updateCita(PostCita $request, int $id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->update($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Cita actualizada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la cita: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyCita(int $id)
    {
        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Cita eliminada correctamente')
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar la cita: ' . $e->getMessage())
                ->send();
        }
    }


}
