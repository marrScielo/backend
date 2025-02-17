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
        Schema::create('especialidades', function (Blueprint $table) {
            $table->increments('idEspecialidad');
            $table->string('nombre',100);
        });

        Schema::create('psicologos', function (Blueprint $table) {
            $table->increments('idPsicologo');
            $table->unsignedInteger('idEspecialidad');
            $table->text('introduccion');
    
            $table->foreign('idEspecialidad')->references('idEspecialidad')->on('especialidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psicologos');
        Schema::dropIfExists('especialidades');
    }
};
