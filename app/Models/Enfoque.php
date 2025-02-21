<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enfoque extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'idEnfoque';
    protected $table = 'enfoques'; 
    protected $fillable = ['nombre'];
    
    public function psicologos()
    {
        return $this->belongsToMany(Psicologo::class, 'enfoque_detalle', 'idEnfoque', 'idPsicologo');
    }
}
