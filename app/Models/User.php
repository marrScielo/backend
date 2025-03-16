<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable, HasRoles;
     protected $primaryKey = 'user_id';
 
     protected $casts = [
        'fecha_nacimiento' => 'date',
     ];

     protected $fillable = [
         'name',
         'apellido',
         'email',
         'password',
         'fecha_nacimiento',
         'imagen',
         'rol'
     ];
 
     public $timestamps = false;

     public function psicologos()
     {
         return $this->hasOne(Psicologo::class, 'user_id', 'user_id');
     }

     public function getEdadAttribute()
     {
         return Carbon::parse($this->fecha_nacimiento)->age;
     }
}
