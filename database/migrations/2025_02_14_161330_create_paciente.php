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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('idPaciente'); 
            $table->string('genero', 20); 
            $table->string('ocupacion', 100);
            $table->string('estadoCivil', 100);
            $table->string('DNI', 8)->unique();
            $table->string('celular', 9); 
            $table->string('direccion',150); 
            $table->unsignedInteger('user_id'); 

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
