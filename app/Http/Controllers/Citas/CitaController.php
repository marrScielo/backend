<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Illuminate\Http\Request;

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

}
