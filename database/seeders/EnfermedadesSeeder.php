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
            ]
        ];


        DB::table('enfermedades')->insert($enfermedades);

    }
    
}
