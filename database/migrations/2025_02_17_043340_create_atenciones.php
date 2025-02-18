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
            $table->string('nombreEnfermedad', 100)->unique(); 
            $table->string('DSM5', 50)->unique(); 
            $table->string('CEA10',50)->unique();
        });

        Schema::create('atenciones', function (Blueprint $table) {
            $table->id('IdAtencion'); 
            $table->unsignedInteger('IdCita'); 
            $table->text('MotivoConsulta');
            $table->string('FormaContacto', 100);
            $table->text('Diagnostico');
            $table->text('Tratamiento');
            $table->text('Observacion');
            $table->text('UltimosObjetivos');
            $table->unsignedInteger('IdEnfermedad'); 
            $table->text('DocumentosAdicionales');
            $table->text('Comentario');
            $table->date('FechaAtencion');

            $table->foreign('IdCita')->references('IdCita')->on('citas')->onDelete('cascade');
            $table->foreign('IdEnfermedad')->references('IdEnfermedad')->on('enfermedades')->onDelete('cascade');
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
