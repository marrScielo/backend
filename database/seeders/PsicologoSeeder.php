<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Psicologo;

class PsicologoSeeder extends Seeder
{
    public function run(): void
    {
        $psicologos = [
            [
                'name' => 'Luis', 'apellido' => 'Gonzales', 'email' => 'luisgonzales@gmail.com',
                'edad' => 32, 'fecha_nacimiento' => '2003-05-01', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'MX', 'experiencia' => 5,
                'genero' => 'masculino', 'introduccion' => 'Soy Luis, profesional en psicología...',
                'horario' => [
                    "Lunes" => [["09:00", "12:00"]],
                    "Martes" => [["10:00", "14:00"]],
                    "Jueves" => [["13:00", "17:00"]]
                ],
                'especialidad' => 1
            ],
            [
                'name' => 'Maria', 'apellido' => 'Fernandez', 'email' => 'mariafernandez@gmail.com',
                'edad' => 28, 'fecha_nacimiento' => '1996-07-12', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'AR', 'experiencia' => 7,
                'genero' => 'femenino', 'introduccion' => 'Soy Maria, especialista en terapia cognitiva...',
                'horario' => [
                    "Martes" => [["08:00", "12:00"]],
                    "Miercoles" => [["14:00", "18:00"]],
                    "Viernes" => [["10:00", "15:00"]]
                ],
                'especialidad' => 2
            ],
            [
                'name' => 'Carlos', 'apellido' => 'Ramirez', 'email' => 'carlosramirez@gmail.com',
                'edad' => 40, 'fecha_nacimiento' => '1984-11-25', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'CO', 'experiencia' => 10,
                'genero' => 'masculino', 'introduccion' => 'Soy Carlos, con experiencia en psicología clínica...',
                'horario' => [
                    "Lunes" => [["07:00", "11:00"]],
                    "Miercoles" => [["09:00", "13:00"]],
                    "Jueves" => [["15:00", "19:00"]]
                ],
                'especialidad' => 3
            ],
            [
                'name' => 'Ana', 'apellido' => 'Lopez', 'email' => 'analopez@gmail.com',
                'edad' => 35, 'fecha_nacimiento' => '1989-03-18', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'PE', 'experiencia' => 8,
                'genero' => 'femenino', 'introduccion' => 'Soy Ana, experta en salud mental y bienestar...',
                'horario' => [
                    "Martes" => [["09:00", "13:00"]],
                    "Jueves" => [["11:00", "16:00"]],
                    "Viernes" => [["14:00", "18:00"]]
                ],
                'especialidad' => 4
            ],
            [
                'name' => 'Javier', 'apellido' => 'Hernandez', 'email' => 'javierhernandez@gmail.com',
                'edad' => 38, 'fecha_nacimiento' => '1986-09-21', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'CL', 'experiencia' => 9,
                'genero' => 'masculino', 'introduccion' => 'Soy Javier, psicólogo con enfoque en terapias familiares...',
                'horario' => [
                    "Lunes" => [["08:00", "12:00"]],
                    "Miercoles" => [["13:00", "17:00"]],
                    "Viernes" => [["10:00", "14:00"]]
                ],
                'especialidad' => 5
            ],
            [
                'name' => 'Elena', 'apellido' => 'Castro', 'email' => 'elenacastro@gmail.com',
                'edad' => 29, 'fecha_nacimiento' => '1995-06-30', 'imagen' => 'https:algo',
                'password' => 'password123', 'pais' => 'EC', 'experiencia' => 6,
                'genero' => 'femenino', 'introduccion' => 'Soy Elena, especialista en psicología infantil...',
                'horario' => [
                    "Martes" => [["08:00", "12:00"]],
                    "Jueves" => [["10:00", "15:00"]],
                    "Sabado" => [["09:00", "13:00"]]
                ],
                'especialidad' => 2
            ]
        ];

        foreach ($psicologos as $data) {
            // Crear el usuario y forzar la carga del ID
            $usuario = User::create([
                'name' => $data['name'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'edad' => $data['edad'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'imagen' => $data['imagen'],
                'password' => Hash::make($data['password']),
                'rol' => 'PSICOLOGO'
            ]);

            // Asignar rol
            $usuario->assignRole('PSICOLOGO');

            $psicologo = Psicologo::create([
                'user_id' => $usuario->user_id,
                'introduccion' => $data['introduccion'],
                'pais' => $data['pais'],
                'experiencia' => $data['experiencia'],
                'genero' => $data['genero'],
                'horario' => $data['horario'],
                'estado' => 'A'
            ]);

            $psicologo->especialidades()->attach([$data['especialidad']]);
        }
    }
}