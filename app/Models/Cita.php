<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cita extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCita'; 

    public function etiqueta()
    {
        return $this->belongsTo(etiqueta::class, foreignKey: 'etiqueta_id'); 

    }
    public function tipoCita()
    {
        return $this->belongsTo(tipoCita::class, foreignKey: 'tipoCita_id'); 
    }
    public function canal()
    {
        return $this->belongsTo(canal::class, foreignKey: 'canal_id');

    }
    public function paciente()
    {
        return $this->belongsTo(canal::class, foreignKey: 'paciente_id');

    }
}
