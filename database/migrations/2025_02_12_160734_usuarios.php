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
        //
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->increments('Usuario_id'); 
            $table->string('name', 100); 
            $table->string('apellido', 100); 
            $table->integer('edad');
            $table->string('email', 100)->unique(); 
            $table->string('password'); 
            $table->string('rol', 100);
            $table->date('fecha_nacimiento');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->string('imagen', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
