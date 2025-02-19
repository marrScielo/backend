<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atencion extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAtencion';
    public $timestamps = false; 
    protected $fillable = [
        'IdCita',
        'MotivoConsulta',
        'FormaContacto',
        'Diagnostico',
        'Tratamiento',
        'Observacion',
        'UltimosObjetivos',
        'IdEnfermedad',
        'Comentario',
        'DocumentosAdicionales',
        'FechaAtencion',
    ];
    
    public function enfermedad()
    {
        return $this->belongsTo(Enfermedad::class, 'idEnfermedad');
    }

    public function citas()
    {
        return $this->belongsTo(Cita::class, 'idCita');
    }
}
