<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Psicologo;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $psicologo = Psicologo::first() ?? Psicologo::create([
            'introduccion' => 'Psicólogo de prueba',
            'pais' => 'PE',
            'genero' => 'masculino',
            'experiencia' => 5,
            'horario' => json_encode(["Lunes" => ["09:00", "12:00"]]),
            'estado' => 'A',
            'user_id' => 1,
        ]);


        $pacientes = [
            [
                'ocupacion' => 'Ingeniero',
                'estadoCivil' => 'Soltero',
                'genero' => 'Masculino',
                'DNI' => '12345678',
                'celular' => '987654321',
                'direccion' => 'Av. Siempre Viva 742',
                'idPsicologo' => $psicologo->id,
            ],
            [
                'ocupacion' => 'Doctora',
                'estadoCivil' => 'Casado',
                'genero' => 'Femenino',
                'DNI' => '87654321',
                'celular' => '912345678',
                'direccion' => 'Calle Falsa 123',
                'idPsicologo' => $psicologo->id,
            ],
        ];

        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }
    }
}
