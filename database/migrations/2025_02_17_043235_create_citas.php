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
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->increments('idEtiqueta');
            $table->string('nombre',100);
        });

        Schema::create('canales', function (Blueprint $table) {
            $table->increments('idCanal')->unique(); 
            $table->string('nombre',100);
        });

        Schema::create('tipocitas', function (Blueprint $table) {
            $table->increments('idTipoCita')->unique(); 
            $table->string('nombre',100); 
        });

        Schema::create('citas', function (Blueprint $table) {
            $table->increments('idCita')->unique(); 
            $table->unsignedInteger('idPaciente'); 
            $table->unsignedInteger('idTipoCita'); 
            $table->unsignedInteger('idCanal'); 
            $table->unsignedInteger('idEtiqueta'); 
            $table->text('motivo_Consulta'); 
            $table->string('estado_Cita', 100); 
            $table->string('colores',100);
            $table->integer('duracion'); 
            $table->date('fecha_cita');
            $table->time('hora_cita');

            $table->foreign('idPaciente')->references('idPaciente')->on('pacientes');
            $table->foreign('idTipoCita')->references('idTipoCita')->on('tipoCitas');
            $table->foreign('idCanal')->references('idCanal')->on('canales');
            $table->foreign('idEtiqueta')->references('idEtiqueta')->on('etiquetas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
        Schema::dropIfExists('etiquetas');
        Schema::dropIfExists('tipocitas');
        Schema::dropIfExists('canales');
    }
};
