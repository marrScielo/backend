<?php

namespace Database\Seeders;

use App\Models\Enfoque;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnfoqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enfoque::create(['nombre' => 'Niños']);
        Enfoque::create(['nombre' => 'Adolescentes']);
        Enfoque::create(['nombre' => 'Familiar']);
        Enfoque::create(['nombre' => 'Pareja']);
        Enfoque::create(['nombre' => 'Adulto']);
    }
}
