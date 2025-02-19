<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cita extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $primaryKey = 'idCita'; 

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
        return $this->belongsTo(canal::class, foreignKey: 'idPaciente');
    }

    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'idCita');
    }
}
