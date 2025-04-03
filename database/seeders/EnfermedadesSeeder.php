<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnfermedadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enfermedades = [
            [
                'nombreEnfermedad' => 'Trastorno de Ansiedad',
                'DSM5' => 'F41.1',
                'CEA10' => 'F41.1'
            ],
            [
                'nombreEnfermedad' => 'Depresión Mayor',
                'DSM5' => 'F32.2',
                'CEA10' => 'F33.2'
            ],
            [
                'nombreEnfermedad' => 'Esquizofrenia',
                'DSM5' => 'F20',
                'CEA10' => 'F20.0'
            ],
            [
                'nombreEnfermedad' => 'Trastorno Bipolar',
                'DSM5' => 'F31.9',
                'CEA10' => 'F31.9'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Pánico',
                'DSM5' => 'F41.0',
                'CEA10' => 'F41.0'
            ],
            [
                'nombreEnfermedad' => 'Trastorno Obsesivo-Compulsivo',
                'DSM5' => 'F42',
                'CEA10' => 'F42'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Estrés Postraumático',
                'DSM5' => 'F43.10',
                'CEA10' => 'F43.1'
            ],
            [
                'nombreEnfermedad' => 'Trastorno Esquizoafectivo',
                'DSM5' => 'F25.1',
                'CEA10' => 'F25.0'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Personalidad Límite',
                'DSM5' => 'F60.3',
                'CEA10' => 'F60.31' // ✅ Cambiado para evitar duplicado
            ],
            [
                'nombreEnfermedad' => 'Trastorno de la Conducta Alimentaria',
                'DSM5' => 'F50.1',
                'CEA10' => 'F50.9'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Déficit de Atención e Hiperactividad',
                'DSM5' => 'F90.1',
                'CEA10' => 'F90.0'
            ],
            [
                'nombreEnfermedad' => 'Trastorno Psicótico Breve',
                'DSM5' => 'F23.1',
                'CEA10' => 'F23.9'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Somatización',
                'DSM5' => 'F45.1',
                'CEA10' => 'F45.0'
            ],
            [
                'nombreEnfermedad' => 'Fobia Específica',
                'DSM5' => 'F40.1',
                'CEA10' => 'F40.2'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Conversión',
                'DSM5' => 'F44.1',
                'CEA10' => 'F44.9'
            ],
            [
                'nombreEnfermedad' => 'Mutismo Selectivo',
                'DSM5' => 'F94.1',
                'CEA10' => 'F94.0'
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Inestabilidad Emocional',
                'DSM5' => 'F60.4',
                'CEA10' => 'F60.32' 
            ],
            [
                'nombreEnfermedad' => 'Trastorno de Evitación y Restricción de la Ingesta de Alimentos',
                'DSM5' => 'F50.2',
                'CEA10' => 'F50.8'
            ],
        ];


        DB::table('enfermedades')->insert($enfermedades);

    }
    
}
