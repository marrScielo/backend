<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class canal extends Model
{
    use HasFactory;

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
