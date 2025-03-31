<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrePaciente extends Model
{
    use HasFactory;

    protected $table = 'pre_pacientes';
    protected $primaryKey = 'idPrePaciente';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'estado',
        'fechaRegistro',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'idPrePaciente');
    }
}
