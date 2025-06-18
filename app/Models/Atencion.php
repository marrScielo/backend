<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Atencion extends Model
{
    protected $table = 'atenciones'; 
    protected $primaryKey = 'idAtencion'; 
    public $timestamps = false;

    protected $fillable = [
        'idCita',
        'diagnostico',
        'tratamiento',
        'observacion',
        'ultimosObjetivos',
        'idEnfermedad',
        'comentario',
        'documentosAdicionales',
        'fechaAtencion',
        
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
