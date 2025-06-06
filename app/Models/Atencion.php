<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atencion extends Model
{
    protected $table = 'atenciones'; 
    protected $primaryKey = 'idAtencion'; 
    public $timestamps = false;

    protected $fillable = [
        'idCita',
        'motivoConsulta',
        'formaContacto',
        'diagnostico',
        'tratamiento',
        'observacion',
        'ultimosObjetivos',
        'idEnfermedad',
        'comentario',
        'documentosAdicionales',
        'fechaAtencion',
        'descripcion',
    ];
    
    public function enfermedad()
    {
        return $this->belongsTo(Enfermedad::class, 'idEnfermedad');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idCita');
    }
}
