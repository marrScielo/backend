<?php

namespace App\Http\Controllers\Pacientes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostPaciente\PostPaciente;
use App\Http\Requests\PutPaciente\PutPaciente;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Psicologo;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function createPaciente(PostPaciente $requestPaciente)
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->unauthorizedResponse('Solo los psicólogos pueden crear pacientes')
                    ->send();
            }

            $pacienteData = $requestPaciente->all();
            $pacienteData['fecha_nacimiento'] = Carbon::createFromFormat('d / m / Y', $pacienteData['fecha_nacimiento'])->format('Y-m-d');
            $pacienteData['idPsicologo'] = $psicologo->idPsicologo;
            $pacienteData['codigo'] = Paciente::generatePacienteCode();

            Paciente::create($pacienteData);

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente creado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.' .
                    $e->getMessage())
                ->send();
        }
    }

    // Conteo de citas por paciente
    public function getCitasPaciente(int $idPaciente)
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->unauthorizedResponse('No se tiene acceso como psicólogo.')
                    ->send();
            }

            $paciente = Paciente::where('idPaciente', $idPaciente)
                ->where('idPsicologo', $psicologo->idPsicologo)
                ->first();

            if (!$paciente) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('El paciente no pertenece al psicólogo autenticado.')
                    ->send();
            }

            // Contar las citas del paciente por estado
            $citasPendientes = Cita::where('idPaciente', $idPaciente)
                ->where('estado_Cita', 'Pendiente')
                ->count();

            $citasCanceladas = Cita::where('idPaciente', $idPaciente)
                ->where('estado_Cita', 'Cancelada')
                ->count();

            $citasConfirmadas = Cita::where('idPaciente', $idPaciente)
                ->where('estado_Cita', 'Confirmada')
                ->count();

            $response = [
                'pendientes' => $citasPendientes,
                'canceladas' => $citasCanceladas,
                'confirmadas' => $citasConfirmadas,
            ];

            return HttpResponseHelper::make()
                ->successfulResponse('Conteo de citas del paciente obtenido correctamente', $response)
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

   public function updatePaciente(PutPaciente $request, int $id)
{
    try {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validated();

        // Si vino fecha en formato d/m/Y, ajústala:
        if (isset($data['fecha_nacimiento'])) {
            $data['fecha_nacimiento'] = Carbon::createFromFormat('d/m/Y', $data['fecha_nacimiento'])
                                           ->format('Y-m-d');
        }

        $paciente->update($data);

        return HttpResponseHelper::make()
            ->successfulResponse('Paciente actualizado correctamente')
            ->send();

    } catch (\Exception $e) {
        return HttpResponseHelper::make()
            ->internalErrorResponse('Error al actualizar: '.$e->getMessage())
            ->send();
    }
}


    public function showPacientesByPsicologo()
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se tiene acceso como psicologo')
                    ->send();
            }

            $pacientes = Paciente::where('idPsicologo', $psicologo->idPsicologo)->get();

            $response = $pacientes->map(function ($paciente) {
                return [
                    'idPaciente' => $paciente->idPaciente,
                    'codigo' => $paciente->codigo,
                    'DNI' => $paciente->DNI,
                    'nombre' => $paciente->nombre . ' ' . $paciente->apellido,
                    'correo' => $paciente->email,
                    'celular' => $paciente->celular,
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Pacientes obtenidos correctamente', $response)
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

   public function showPacienteById($id)
{
    try {
        $userId = Auth::id();
        $psicologo = Psicologo::where('user_id', $userId)->first();

        if (!$psicologo) {
            return HttpResponseHelper::make()
                ->notFoundResponse('No se tiene acceso como psicólogo.')
                ->send();
        }

        // Solo agregar with() a tu consulta existente
        $paciente = Paciente::with('registroFamiliar')
                ->where('idPaciente', $id)
                ->where('idPsicologo', $psicologo->idPsicologo)
                ->first();

        if (!$paciente) {
            return HttpResponseHelper::make()
                ->notFoundResponse('No se encontró el paciente solicitado o no tienes acceso a este paciente.')
                ->send();
        }

        return HttpResponseHelper::make()
            ->successfulResponse('Paciente obtenido correctamente', $paciente->toArray())
            ->send();
    } catch (\Exception $e) {
        return HttpResponseHelper::make()
            ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
            ->send();
    }
}
    public function destroyPaciente(int $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Paciente eliminado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar el blog: ' . $e->getMessage())
                ->send();
        }
    }

    public function searchPacientes(Request $request)
{
    try {
        $userId = Auth::id();
        $psicologo = Psicologo::where('user_id', $userId)->first();

        if (!$psicologo) {
            return HttpResponseHelper::make()
                ->unauthorizedResponse('No se tiene acceso como psicólogo')
                ->send();
        }

        $search = $request->query('search', '');

        $pacientes = Paciente::where('idPsicologo', $psicologo->idPsicologo)
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%$search%")
                      ->orWhere('apellido', 'LIKE', "%$search%");
            })
            ->select('idPaciente', 'nombre', 'apellido', 'codigo')
            ->limit(10)
            ->get();

        $response = $pacientes->map(function ($paciente) {
            return [
                'id' => $paciente->idPaciente,
                'nombre' => $paciente->nombre . ' ' . $paciente->apellido,
                'codigo' => $paciente->codigo,
            ];
        });

        return HttpResponseHelper::make()
            ->successfulResponse('Resultados encontrados', $response)
            ->send();

    } catch (\Exception $e) {
        return HttpResponseHelper::make()
            ->internalErrorResponse('Ocurrió un error al buscar pacientes. ' . $e->getMessage())
            ->send();
    }
}   

    public function pacientesAll(){
        try {
            $pacientes = Paciente::all();
            return HttpResponseHelper::make()
                ->successfulResponse('Pacientes obtenidos correctamente', $pacientes)
                ->send();
            
        } catch (\Throwable $th) {
            //throw $th;
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud.')
                ->send();
        }
    }
        
}
