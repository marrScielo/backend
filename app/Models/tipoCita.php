<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoCita extends Model
{
    use HasFactory;
    protected $table = 'tipo_citas'; 
    protected $primaryKey = 'idTipoCita'; 
    public $timestamps = false; 

    protected $fillable = ['nombre'];
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idTipoCita');
    }
}
