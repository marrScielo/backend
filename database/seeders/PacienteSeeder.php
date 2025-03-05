<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pacientes = [
            [
                'ocupacion' => 'Ingeniero',
                'estadoCivil' => 'Soltero',
                'genero' => 'Masculino',
                'DNI' => '12345678',
                'celular' => '987654321',
                'direccion' => 'Av. Siempre Viva 742',
            ],
            [
                'ocupacion' => 'Doctora',
                'estadoCivil' => 'Casado',
                'genero' => 'Femenino',
                'DNI' => '87654321',
                'celular' => '912345678',
                'direccion' => 'Calle Falsa 123',
            ],
        ];

        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }
    }
}
