<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administradores extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'administradores';
    protected $primaryKey = 'idAdmin';
    
    protected $fillable = [
        'user_id', // Solo deberías tener campos específicos de administrador aquí
        'estado'   // Los demás campos (nombre, email, etc.) están en User
    ];

    protected $attributes = [
        'estado' => 'A',
    ];

    // Relación correctamente nombrada en singular
   // En App/Models/Administradores.php
public function user() // Asegúrate de usar singular
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}
}