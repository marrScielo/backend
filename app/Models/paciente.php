<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Paciente extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPaciente';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'pacientes';
    public $timestamps = false; 

    protected $casts = [
        'fecha_nacimiento' => 'date',
     ];

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'fecha_nacimiento',
        'ocupacion',
        'estadoCivil',
        'genero',
        'DNI',
        'celular',
        'direccion',
        'idPsicologo',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'idPaciente');
    }
    
    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'idPsicologo');
    }

    public function registroFamiliar()
    {
        return $this->hasOne(RegistroFamiliar::class, 'idPaciente');
    }

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

}
