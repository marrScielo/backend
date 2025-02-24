<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Adicciones'],
            ['nombre' => 'Ansiedad'],
            ['nombre' => 'Atención'],
            ['nombre' => 'Autoestima'],
            ['nombre' => 'Crianza'],
            ['nombre' => 'Depresión'],
            ['nombre' => 'Enfermedades Crónicas'],
            ['nombre' => 'Estrés'],
            ['nombre' => 'Impulsividad'],
            ['nombre' => 'Top'],
            ['nombre' => 'Ira'],
            ['nombre' => 'Terapia de Pareja'],
            ['nombre' => 'Sexualidad'],
            ['nombre' => 'Traumas'],
            ['nombre' => 'Riesgo Suicida'],
            ['nombre' => 'Sentido de Vida'],
            ['nombre' => 'Orientación Vocacional'],
            ['nombre' => 'Problemas de Sueño'],
            ['nombre' => 'Problemas Alimenticios'],
            ['nombre' => 'Relaciones Interpersonales'],
        ];

        Especialidad::insert($especialidades);
    }
}
