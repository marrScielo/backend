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
            $table->foreignId('paciente_id'); 
            $table->foreignId('tipoCita_id'); 
            $table->foreignId('canal_id'); 
            $table->foreignId('etiqueta_id'); 
            $table->string('motivo_Consulta', 1000); 
            $table->string('estado_Cita', 100); 
            $table->string('colores',100);
            $table->integer('duracion'); 
            $table->date('fecha_cita');
            $table->time('hora_cita');

            $table->foreign('paciente_id')->references('paciente_id')->on('paciente');
            $table->foreign('tipoCita_id')->references('tipoCita_id')->on('tipoCita');
            $table->foreign('canal_id')->references('canal_id')->on('canal');
            $table->foreign('etiqueta_id')->references('etiqueta_id')->on('etiqueta');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
