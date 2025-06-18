<?php

namespace App\Http\Controllers\Atencion;

use App\Http\Controllers\Controller;
use App\Models\Atencion;
use Illuminate\Http\Request;
use App\Http\Requests\PostAtencion\PostAtencion;
use App\Http\Requests\PutAtencion\PutAtencion;
use App\Models\Cita;
use App\Traits\HttpResponseHelper;
use Carbon\Carbon;
use Exception;

class AtencionController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
    }

    /**
     * Crear una nueva atención médica
     */
    public function createAtencion(PostAtencion $request, int $idCita)
    {
        try {
            $data = $request->validated();
            $data['idCita'] = $idCita;

            // Manejo de archivo si viene
            if ($request->hasFile('documentosAdicionales')) {
                $file = $request->file('documentosAdicionales');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documentos_atencion', $filename, 'public');
                $data['documentosAdicionales'] = $path;
            }

            // Agregar fecha de atención si no viene en el request
            if (!isset($data['fechaAtencion'])) {
                $data['fechaAtencion'] = Carbon::now()->format('Y-m-d H:i:s');
            }

            // Crear la atención
            $atencion = Atencion::create($data);

            // Actualizar el estado de la cita a "Confirmada"
            Cita::where('idCita', $idCita)->update(['estado_Cita' => 'Confirmada']);

            return HttpResponseHelper::make()
                ->successfulResponse('Atención creada y cita confirmada correctamente', $atencion->toArray())
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al crear la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener la última atención de un paciente específico
     */
    public function showAtencionByPaciente($idPaciente)
    {
        try {
            $atencion = Atencion::with(['cita.paciente', 'enfermedad'])
                ->whereHas('cita', function ($query) use ($idPaciente) {
                    $query->where('idPaciente', $idPaciente);
                })
                ->orderByDesc('fechaAtencion')
                ->first();

            if (!$atencion) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se encontró ninguna atención válida para este paciente.')
                    ->send();
            }

            $fechaFormateada = Carbon::parse($atencion->fechaAtencion)->format('d/m');

            $resultado = [
                'nombre' => $atencion->cita->paciente->nombre ?? 'N/A',
                'apellido' => $atencion->cita->paciente->apellido ?? 'N/A',
                'DNI' => $atencion->cita->paciente->DNI ?? 'N/A',
                'codigo' => $atencion->cita->paciente->codigo ?? 'N/A',
                'celular' => $atencion->cita->paciente->celular ?? 'N/A',
                'edad' => $atencion->cita->paciente->edad ?? 'N/A',
                'fecha_completa' => Carbon::parse($atencion->fechaAtencion)->translatedFormat('l d \d\e F \d\e Y'),
                'fecha_atencion' => $fechaFormateada,
                'diagnostico' => $atencion->diagnostico,
                'observacion' => $atencion->observacion,
                'ultimosObjetivos' => $atencion->ultimosObjetivos,
                'comentario' => $atencion->comentario,
                'tratamiento' => $atencion->tratamiento,
                'descripcion' => $atencion->descripcion,
                'documentosAdicionales' => $atencion->documentosAdicionales,
                'idEnfermedad' => $atencion->idEnfermedad,
                'enfermedad' => $atencion->enfermedad->nombre ?? null,
                'idAtencion' => $atencion->idAtencion,
            ];

            return HttpResponseHelper::make()
                ->successfulResponse('Última atención del paciente obtenida correctamente', $resultado)
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la última atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener todas las atenciones del sistema
     */
    public function showAllAtenciones()
    {
        try {
            $atenciones = Atencion::with(['cita.paciente', 'cita.prepaciente', 'enfermedad'])
                ->get()
                ->map(function ($atencion) {
                    $cita = $atencion->cita;

                    // Buscar nombre de paciente o prepaciente
                    if ($cita && $cita->paciente) {
                        $nombre = $cita->paciente->nombre . ' ' . $cita->paciente->apellido;
                        $codigo = $cita->paciente->codigo;
                        $idPaciente = $cita->idPaciente;
                    } elseif ($cita && $cita->prepaciente) {
                        $nombre = $cita->prepaciente->nombre . ' ' . $cita->prepaciente->apellido;
                        $codigo = null;
                        $idPaciente = null;
                    } else {
                        $nombre = 'Nombre no disponible';
                        $codigo = null;
                        $idPaciente = null;
                    }

                    return [
                        'hora_inicio' => $cita->hora_cita ?? 'N/A',
                        'nombre_completo' => $nombre,
                        'diagnostico' => $atencion->diagnostico,
                        'fecha_inicio' => $atencion->fechaAtencion,
                        'idCita' => $cita->idCita ?? null,
                        'idAtencion' => $atencion->idAtencion,
                        'idPaciente' => $idPaciente,
                        'codigo' => $codigo,
                        'enfermedad' => $atencion->enfermedad->nombre ?? null,
                    ];
                });

            return HttpResponseHelper::make()
                ->successfulResponse('Todas las atenciones obtenidas correctamente', $atenciones->toArray())
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las atenciones: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener todas las atenciones de un paciente específico
     */
    public function showAllAtencionesPaciente(int $id)
    {
        try {
            $atenciones = Atencion::with(['cita.paciente', 'cita.prepaciente', 'enfermedad'])
                ->whereHas('cita', function ($query) use ($id) {
                    $query->where('idPaciente', $id);
                })
                ->orderByDesc('fechaAtencion')
                ->get()
                ->map(function ($atencion) {
                    $cita = $atencion->cita;

                    // Si existe paciente, lo usamos. Si no, buscamos el prepaciente.
                    if ($cita && $cita->paciente) {
                        $nombre = $cita->paciente->nombre . ' ' . $cita->paciente->apellido;
                    } elseif ($cita && $cita->prepaciente) {
                        $nombre = $cita->prepaciente->nombre . ' ' . $cita->prepaciente->apellido;
                    } else {
                        $nombre = 'Nombre no disponible';
                    }

                    return [
                        'hora_inicio' => $cita->hora_cita ?? 'N/A',
                        'nombre_completo' => $nombre,
                        'diagnostico' => $atencion->diagnostico,
                        'fecha_inicio' => $atencion->fechaAtencion,
                        'idCita' => $cita->idCita ?? null,
                        'idAtencion' => $atencion->idAtencion,
                        'enfermedad' => $atencion->enfermedad->nombre ?? null,
                        'tratamiento' => $atencion->tratamiento,
                        'observacion' => $atencion->observacion,
                    ];
                });

            return HttpResponseHelper::make()
                ->successfulResponse('Atenciones del paciente obtenidas correctamente', $atenciones->toArray())
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener las atenciones del paciente: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Obtener una atención específica por ID
     */
    public function showAtencionByCita(int $idCita)
    {
        try {
            $atencion = Atencion::with(['cita.paciente', 'enfermedad'])
                ->where('idCita', $idCita)
                ->first();

            if (!$atencion) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('No se encontró ninguna atención para esta cita.')
                    ->send();
            }

            $resultado = [
                'idAtencion' => $atencion->idAtencion,
                'idCita' => $atencion->idCita,
                'diagnostico' => $atencion->diagnostico,
                'tratamiento' => $atencion->tratamiento,
                'observacion' => $atencion->observacion,
                'ultimosObjetivos' => $atencion->ultimosObjetivos,
                'idEnfermedad' => $atencion->idEnfermedad,
                'comentario' => $atencion->comentario,
                'documentosAdicionales' => $atencion->documentosAdicionales,
                'fechaAtencion' => $atencion->fechaAtencion,
                'descripcion' => $atencion->descripcion,
                'enfermedad' => $atencion->enfermedad->nombre ?? null,
                'paciente' => $atencion->cita->paciente ? [
                    'nombre' => $atencion->cita->paciente->nombre,
                    'apellido' => $atencion->cita->paciente->apellido,
                    'DNI' => $atencion->cita->paciente->DNI,
                ] : null,
            ];

            return HttpResponseHelper::make()
                ->successfulResponse('Atención obtenida correctamente', $resultado)
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al obtener la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Actualizar una atención existente
     */
    public function updateAtencionByCita(PutAtencion $request, int $idCita)
    {
        try {
            $atencion = Atencion::where('idCita', $idCita)->firstOrFail();

            $data = $request->validated();

            // Manejo de archivo si viene en la actualización
            if ($request->hasFile('documentosAdicionales')) {
                $file = $request->file('documentosAdicionales');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documentos_atencion', $filename, 'public');
                $data['documentosAdicionales'] = $path;
            }

            $atencion->update($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Atención actualizada correctamente', $atencion->toArray())
                ->send();
        } catch (Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la atención: ' . $e->getMessage())
                ->send();
        }
    }

    /**
     * Eliminar una atención
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
