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
        Schema::create('enfoques', function (Blueprint $table) {
            $table->increments('idEnfoque');
            $table->string('nombre');
        });

        Schema::create('especialidades', function (Blueprint $table) {
            $table->increments('idEspecialidad');
            $table->string('nombre',100);
        });

        Schema::create('psicologos', function (Blueprint $table) {
            $table->increments('idPsicologo');
            $table->text('introduccion');
            $table->string('pais', '50');
            $table->string('genero', '50');
            $table->integer('experiencia');
            $table->json('horario');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        // Tabla intermedia entre psicólogos y especialidades (Muchos a Muchos)
        Schema::create('especialidad_detalle', function (Blueprint $table) {
            $table->unsignedInteger('idPsicologo');
            $table->unsignedInteger('idEspecialidad');

            $table->foreign('idPsicologo')->references('idPsicologo')->on('psicologos')->onDelete('cascade');
            $table->foreign('idEspecialidad')->references('idEspecialidad')->on('especialidades')->onDelete('cascade');
        });

        // Tabla intermedia entre psicólogos y enfoques (Muchos a Muchos)
        Schema::create('enfoque_detalle', function (Blueprint $table) {
            $table->unsignedInteger('idPsicologo');
            $table->unsignedInteger('idEnfoque');

            $table->foreign('idPsicologo')->references('idPsicologo')->on('psicologos')->onDelete('cascade');
            $table->foreign('idEnfoque')->references('idEnfoque')->on('enfoques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidad_detalle');
        Schema::dropIfExists('enfoque_detalle');
        Schema::dropIfExists('psicologos');
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('enfoques');
    }
};
