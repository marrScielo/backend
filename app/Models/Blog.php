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
        'idCategoria', 
        'tema',
        'contenido',
        'imagen',
        'idPsicologo',
    ];

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'idPsicologo');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idBlog');
    }
}
