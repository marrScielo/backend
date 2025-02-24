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
        'horario'
    ];


    protected $casts = [
        'horario' => 'array',
    ];
    
    // Relación muchos a muchos con Especialidades
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'especialidad_detalle', 'idPsicologo', 'idEspecialidad');
    }

    // Relación muchos a muchos con Enfoques
    public function enfoques()
    {
        return $this->belongsToMany(Enfoque::class, 'enfoque_detalle', 'idPsicologo', 'idEnfoque');
    }

    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'idPsicologo', 'idPsicologo');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
