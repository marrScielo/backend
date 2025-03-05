<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    use HasFactory;
    
    public $timestamps = false; 
    protected $primaryKey = 'idPsicologo';
    protected $fillable = [
        'introduccion',
        'user_id',
        'pais',
        'genero',
        'experiencia',
        'horario',
        'estado'
    ];


    protected $attributes = [
        'estado' => 'A', 
    ];

    protected $casts = [
        'horario' => 'array',
    ];
    
    // Relación muchos a muchos con Especialidades
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'especialidad_detalle', 'idPsicologo', 'idEspecialidad');
    }
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'idPsicologo', 'idPsicologo');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'idPaciente', 'idPaciente');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
