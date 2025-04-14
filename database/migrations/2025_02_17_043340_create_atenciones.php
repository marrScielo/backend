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
        Schema::create('enfermedades', function (Blueprint $table) {
            $table->increments('idEnfermedad'); 
            $table->string('nombreEnfermedad', 500); 
            $table->string('DSM5', 50); 
            $table->string('CEA10',50);
        });

        Schema::create('atenciones', function (Blueprint $table) {
            $table->id('IdAtencion'); 
            $table->unsignedBigInteger('idCita');
            $table->text('MotivoConsulta');
            $table->string('FormaContacto', 100);
            $table->text('Diagnostico');
            $table->text('Tratamiento');
            $table->text('Observacion');
            $table->text('UltimosObjetivos');
            $table->unsignedInteger('idEnfermedad'); 
            $table->text('DocumentosAdicionales')->nullable();
            $table->text('Comentario');
            $table->date('FechaAtencion');
            $table->text('descripcion')->nullable();

            $table->foreign('idCita')->references('idCita')->on('citas')->onDelete('cascade');
            $table->foreign('idEnfermedad')->references('idEnfermedad')->on('enfermedades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atenciones');
        Schema::dropIfExists('enfermedades');
    }
};
