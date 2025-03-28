<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrePaciente;
use Carbon\Carbon;

class PrePacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pre_pacientes = [
            [
                'nombre' => 'Juan', 'apellido' => 'Pérez', 'correo' => 'juanperez@gmail.com',
                'estado' => 'pendiente', 'fechaRegistro' => Carbon::now(),
            ],
            [
                'nombre' => 'Laura', 'apellido' => 'Gómez', 'correo' => 'lauragomez@gmail.com',
                'estado' => 'pendiente', 'fechaRegistro' => Carbon::now(),
            ],
            [
                'nombre' => 'Carlos', 'apellido' => 'Martínez', 'correo' => 'carlosmartinez@gmail.com',
                'estado' => 'registrado', 'fechaRegistro' => Carbon::now(),
            ],
            [
                'nombre' => 'Sofía', 'apellido' => 'Ramírez', 'correo' => 'sofiaramirez@gmail.com',
                'estado' => 'pendiente', 'fechaRegistro' => Carbon::now(),
            ],
            [
                'nombre' => 'Ricardo', 'apellido' => 'Fernández', 'correo' => 'ricardofernandez@gmail.com',
                'estado' => 'registrado', 'fechaRegistro' => Carbon::now(),
            ],
            [
                'nombre' => 'Mariana', 'apellido' => 'López', 'correo' => 'marianalopez@gmail.com',
                'estado' => 'pendiente', 'fechaRegistro' => Carbon::now(),
            ],
        ];

        foreach ($pre_pacientes as $paciente) {
            PrePaciente::create($paciente);
        }
    }
}
