<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'comentario',
        'idBlog',
    ];

    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'idBlog');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'idComentario');
    }
}
