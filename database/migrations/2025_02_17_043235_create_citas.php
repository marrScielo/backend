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
            $table->string('nombre', 100);
        });

        Schema::create('canales', function (Blueprint $table) {
            $table->increments('idCanal'); 
            $table->string('nombre', 100);
        });

        Schema::create('tipo_citas', function (Blueprint $table) {
            $table->increments('idTipoCita'); 
            $table->string('nombre', 100); 
        });

        Schema::create('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('idCita')->autoIncrement();
            $table->unsignedInteger('idPaciente'); 
            $table->unsignedInteger('idTipoCita'); 
            $table->unsignedInteger('idCanal'); 
            $table->unsignedInteger('idEtiqueta'); 
            $table->text('motivo_Consulta')->nullable(); 
            $table->string('estado_Cita', 100)->nullable();
            $table->string('colores', 100)->nullable();
            $table->integer('duracion')->nullable(); 
            $table->date('fecha_cita')->nullable();
            $table->time('hora_cita')->nullable();

            $table->foreign('idPaciente')->references('idPaciente')->on('pacientes')->cascadeOnDelete();
            $table->foreign('idTipoCita')->references('idTipoCita')->on('tipo_citas')->cascadeOnDelete();
            $table->foreign('idCanal')->references('idCanal')->on('canales')->cascadeOnDelete();
            $table->foreign('idEtiqueta')->references('idEtiqueta')->on('etiquetas')->cascadeOnDelete();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
        Schema::dropIfExists('etiquetas');
        Schema::dropIfExists('tipo_citas');
        Schema::dropIfExists('canales');
    }
};
