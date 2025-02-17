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
        Schema::create('cita', function (Blueprint $table) {
            $table->increments('cita_id')->unique(); 
            $table->foreignId('idPaciente'); 
            $table->foreignId('idTipoCita'); 
            $table->foreignId('idCanal'); 
            $table->foreignId('idEtiqueta'); 
            $table->string('motivo_Consulta', 1000); 
            $table->string('estado_Cita', 100); 
            $table->string('colores',100);
            $table->integer('duracion'); 
            $table->date('fecha_cita');
            $table->time('hora_cita');

            $table->foreign('idPaciente')->references('idPaciente')->on('paciente');
            $table->foreign('idTipoCita')->references('idTipoCita')->on('tipoCita');
            $table->foreign('idCanal')->references('idCanal')->on('canal');
            $table->foreign('idEtiqueta')->references('idEtiqueta')->on('etiqueta');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
