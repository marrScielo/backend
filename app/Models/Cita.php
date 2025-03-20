<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas'; 
    protected $primaryKey = 'idCita'; 
    public $timestamps = false; 

    protected $attributes = [
        'colores' => '#FFA500', 
    ];

    protected $fillable = [
        'idPaciente',
        'idTipoCita',
        'idCanal',
        'idEtiqueta',
        'idPsicologo',
        'motivo_Consulta',
        'estado_Cita',
        'colores',
        'duracion',
        'fecha_cita',
        'hora_cita',
    ];

    public function etiqueta()
    {
        return $this->belongsTo(etiqueta::class, foreignKey: 'idEtiqueta'); 
    }

    public function tipoCita()
    {
        return $this->belongsTo(tipoCita::class, foreignKey: 'idTipoCita'); 
    }

    public function canal()
    {
        return $this->belongsTo(canal::class, foreignKey: 'idCanal');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, foreignKey: 'idPaciente');
    }

    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'idCita');
    }
}
