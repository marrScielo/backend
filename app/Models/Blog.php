<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $primaryKey = 'idBlog';
    public $timestamps = false; 

    protected $fillable = [
        'idEspecialidad',
        'tema',
        'contenido',
        'imagen',
        'idPsicologo',
    ];

    public function psicologos()
    {
        return $this->belongsTo(Psicologo::class, 'idPsicologo');
    }
    public function especialidades()
    {
        return $this->belongsTo(Especialidad::class, 'idEspecialidad');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idBlog');
    }
}