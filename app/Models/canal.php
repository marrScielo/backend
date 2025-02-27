<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Canal extends Model
{
    use HasFactory;
    protected $table = 'canales';
    public $timestamps = false; 
    protected $fillable = ['nombre'];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
