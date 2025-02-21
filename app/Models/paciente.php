<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    public $timestamps = false; 
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idPaciente');
    }
}
