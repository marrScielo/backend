<?php

namespace Database\Seeders;

use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsicologoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $usuario = User::create([
            'name' => 'Luis',
            'apellido' => 'Gonzales',
            'email' => 'luisgonzales@gmail.com',
            'edad' => 32,
            'fecha_nacimiento' => '2003-05-01',
            'imagen' => 'https:algo',
            'password' => Hash::make('password123'),
            'rol' => 'PSICOLOGO',
        ]);

        $psicologo = Psicologo::create([
            'user_id' => $usuario->user_id, 
            'introduccion' => 'Soy Luis, profesional en psicología...',
            'pais' => 'MX',
            'experiencia' => 5,
            'genero' => 'masculino',
            'horario' => [
                "Lunes" => [["09:00", "12:00"]],
                "Martes" => [["10:00", "15:00"]],
                "Miercoles" => [["12:00", "16:00"]],
            ],
        ]);

        $psicologo->especialidades()->attach([1]);
        $psicologo->enfoques()->attach([1, 2]);

        $usuario->assignRole('PSICOLOGO');
    }
}
