<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class contactos extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'nombre',
        'apellido',
        'celular',
        'email',
        'comentario',
    ];
}
