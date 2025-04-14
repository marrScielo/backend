<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Psicologo;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;

class DashboardController extends Controller
{
    public function psicologoDashboard()
    {
        $userId = Auth::id();
        $psicologo = Psicologo::where('user_id', $userId)->first();
    
        if (!$psicologo) {
            return HttpResponseHelper::make()
                ->notFoundResponse('No se encontró un psicólogo asociado a este usuario.')
                ->send();
        }
    
        $idPsicologo = $psicologo->idPsicologo;
    
        // Obtener citas del psicólogo
        $totalCitas = Cita::where('idPsicologo', $idPsicologo)->count();
        $citasCompletadas = Cita::where('idPsicologo', $idPsicologo)->where('estado_Cita', 'completada')->count();
        $citasPendientes = Cita::where('idPsicologo', $idPsicologo)->where('estado_Cita', 'pendiente')->count();
        $citasCanceladas = Cita::where('idPsicologo', $idPsicologo)->where('estado_Cita', 'cancelada')->count();

        $totalMinutosReservados = Cita::where('idPsicologo', $idPsicologo)
        ->whereIn('estado_Cita', ['completada', 'pendiente'])  
        ->sum('duracion');  
    
        return HttpResponseHelper::make()
            ->successfulResponse('Datos del dashboard cargados correctamente',[
               'total_citas' => $totalCitas,
            'citas_completadas' => $citasCompletadas,
            'citas_pendientes' => $citasPendientes,
            'citas_canceladas' => $citasCanceladas,
            'total_minutos_reservados' => $totalMinutosReservados, 
            ])
            ->send();
    }
}

