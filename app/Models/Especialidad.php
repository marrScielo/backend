<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidad extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'idEspecialidad';
    protected $table = 'especialidades'; 
    protected $fillable = ['nombre'];

    
    public function psicologos()
    {
        return $this->belongsToMany(Psicologo::class, 'especialidad_detalle', 'idEspecialidad', 'idPsicologo');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'idEspecialidad');
    }
}
