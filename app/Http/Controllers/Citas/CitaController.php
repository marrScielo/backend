<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Illuminate\Http\Request;
use App\Http\Requests\CitaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;


class CitaController extends Controller
{
    
    public function showById(Request $request, int $id)
    {
        try {
            $mes = $request->query('mes');

            $citas = Cita::where('idPsicologo', $id)
                ->when($mes, function ($query) use ($mes) {
                    $query->whereMonth('fecha_cita', $mes);
                })
                ->get()
                ->map(function ($cita) {
                    return [
                        'duracion' => $cita->duracion,
                        'fecha_cita' => $cita->fecha_cita,
                        'hora_cita' => $cita->hora_cita,
                    ];
                });

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de citas obtenida correctamente', $citas)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener las citas: ' . $e->getMessage())
                ->send();
        }
    }

    public function store(CitaRequest $request)
    {
        try {
            
            $cita = Cita::create($request->validated());

            
            $cita = Cita::with(['etiqueta', 'tipoCita', 'canal', 'paciente', 'atenciones'])
                        ->where('idCita', $cita->idCita) 
                        ->first();

            if (!$cita) {
                return response()->json(['error' => 'No se pudo recuperar la cita después de la creación'], 500);
            }

            return response()->json([
                'message' => 'Cita creada correctamente',
                'cita' => $cita
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear la cita', 'details' => $e->getMessage()], 500);
        }
    }

    public function show($idCita)
    {
        try {
            $cita = Cita::with(['etiqueta', 'tipoCita', 'canal', 'paciente', 'atenciones'])
                        ->findOrFail($idCita); 
            return response()->json($cita);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }
    }

    public function update(CitaRequest $request, $idCita)
    {
        try {
            $cita = Cita::findOrFail($idCita);
            $cita->update($request->validated());

            $cita = Cita::with(['etiqueta', 'tipoCita', 'canal', 'paciente', 'atenciones'])
                        ->find($cita->idCita);

            return response()->json([
                'message' => 'Cita actualizada correctamente',
                'cita' => $cita
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al actualizar la cita', 'details' => $e->getMessage()], 500);
        }

    }

    public function destroy($idCita)
    {
        try {
            $cita = Cita::findOrFail($idCita);
            $cita->delete();
            return response()->json(['message' => 'Cita eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar la cita. Puede estar relacionada con otros registros.', 'details' => $e->getMessage()], 400);
        }
    }


}
