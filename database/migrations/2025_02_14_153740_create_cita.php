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
            $table->string('paciente_id',100); 
            $table->string('tipoCita_id',100); 
            $table->string('canal_id',100); 
            $table->string('etiqueta_id',100); 
            $table->string('motivo_Consulta', 1000); 
            $table->string('estado_Cita', 100); 
            $table->string('colores',100);
            $table->integer('duracion'); 
            $table->date('fecha_cita');
            $table->time('hora_cita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
