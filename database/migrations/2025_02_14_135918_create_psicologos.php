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
            $table->unsignedInteger('idEspecialidad');
            $table->unsignedInteger('idEnfoque');
            $table->text('introduccion');
            $table->unsignedInteger('user_id');
    
            $table->foreign('idEspecialidad')->references('idEspecialidad')->on('especialidades')->onDelete('cascade');
            $table->foreign('idEnfoque')->references('idEnfoque')->on('enfoques')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psicologos');
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('enfoques');
    }
};
