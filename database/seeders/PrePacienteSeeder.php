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
                'nombre' => 'Juan Pérez', 'correo' => 'juanperez@gmail.com',
                'celular' => '978156123'
            ],
            [
                'nombre' => 'Laura Gómez', 'correo' => 'lauragomez@gmail.com',
                'celular' => '908156123'
            ],
            [
                'nombre' => 'Carlos Martínez', 'correo' => 'carlosmartinez@gmail.com',
                'celular' => '918156123'
            ],
            [
                'nombre' => 'Sofía Ramírez', 'correo' => 'sofiaramirez@gmail.com',
                'celular' => '928156123'
            ]
        ];

        foreach ($pre_pacientes as $paciente) {
            PrePaciente::create($paciente);
        }
    }
}
