<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pre_pacientes', function (Blueprint $table) {
            $table->increments('idPrePaciente');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo')->unique();
            $table->string('estado')->default('pendiente'); 
            $table->timestamp('fechaRegistro')->useCurrent();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::dropIfExists('pre_pacientes');
    }
};
