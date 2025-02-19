<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enfoque extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $fillable = ['nombre'];
    
    public function psicologos(): HasMany
    {
        return $this->hasMany(Psicologo::class, 'idEnfoque');
    }
}
