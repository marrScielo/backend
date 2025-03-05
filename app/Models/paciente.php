<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    public $timestamps = false; 
    protected $fillable = [
        'ocupacion',
        'estadoCivil',
        'genero',
        'DNI',
        'celular',
        'direccion',
        'idPsicologo'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'idPaciente');
    }
    
    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'idPsicologo');
    }

}
