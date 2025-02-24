<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etiqueta extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $fillable = ['nombre'];
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idEtiqueta');
    }
}
