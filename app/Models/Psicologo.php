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
        'experiencia'
    ];

    // Relación Muchos a Muchos con Especialidades
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'especialidad_detalle', 'idPsicologo', 'idEspecialidad');
    }

    // Relación Muchos a Muchos con Enfoques
    public function enfoques()
    {
        return $this->belongsToMany(Enfoque::class, 'enfoque_detalle', 'idPsicologo', 'idEnfoque');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'idPsicologo');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
