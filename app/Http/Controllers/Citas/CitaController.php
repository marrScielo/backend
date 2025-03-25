<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Illuminate\Http\Request;
use App\Http\Requests\PostCita\PostCita;
use App\Models\Psicologo;
use Exception;
use Illuminate\Support\Facades\Auth;

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
                    'paciente' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido, 
                    'codigo' => $cita->paciente->codigo, 
                    'motivo' => $cita->motivo_Consulta,
                    'estado' => $cita->estado_Cita,
                    'fecha_inicio' => $cita->fecha_cita . ' ' . $cita->hora_cita,
                    'duracion' => $cita->duracion . ' min.'
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
            ->map(function ($cita) {
                return [
                    'idCita' => $cita->idCita,
                    'fecha' => $cita->fecha_cita,
                    'hora' => $cita->hora_cita,
                    'duracion' => $cita->duracion . 'min.',
                ];
            });

            return HttpResponseHelper::make()
            ->successfulResponse('Citas obtenida correctamente', $cita->toArray())
            ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la cita: ' . $e->getMessage())
                ->send();
        }
    }

    public function showCitasPendientes(int $id)
    {
        try {
            $citas = Cita::where('estado_Cita', 'Pendiente')
            ->where('idPsicologo', $id)
            ->get()
            ->map(function ($cita) {
                return [
                    'fecha' => $cita->fecha_cita,
                    'hora'  => substr($cita->hora_cita, 0, 5),
                    'duracion' => $cita->duracion,
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
