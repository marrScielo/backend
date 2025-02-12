<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    //
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    protected $primaryKey = 'Usuario_id';
    protected $fillable = [
        'name',
        'apellido',
        'edad',
        'email',
        'password',
        'rol',
        'fecha_nacimiento',
        'imagen',
       
    ];
    public $timestamps = false;
}
