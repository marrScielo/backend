<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Respuesta extends Model
{
    use HasFactory;
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'respuesta',
        'idComentario',
    ];

    public function comentarios()
    {
        return $this->belongsTo(Comentario::class, 'idComentario');
    }
}
