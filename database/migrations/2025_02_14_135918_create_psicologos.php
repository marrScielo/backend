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
        Schema::create('psicologos', function (Blueprint $table) {
            $table->increments('idPsicologo');
            $table->integer('idEspecialidad');
            $table->string('introduccion', 400)->charset('utf8');
    
            $table->foreign('idEspecialidad')->references('idEspecialidad')->on('especialidad')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psicologos');
    }
};
