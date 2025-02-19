<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $fillable = [
        'idEspecialidad',
        'introduccion',
        'user_id',
        'idEnfoque',
    ];

    public function especialidades()
    {
        return $this->belongsTo(Especialidad::class, 'idEspecialidad');
    }

    public function enfoques()
    {
        return $this->belongsTo(Enfoque::class, 'idEnfoque');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'idPsicologo');
    }
}
