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
        Schema::create('contactanos', function (Blueprint $table) {
            $table->increments('contactanos_id'); 
            $table->string('name', 100); 
            $table->string('apellido', 100); 
            $table->integer('celular',9)->unique();
            $table->string('email', 100)->unique(); 
            $table->string('mensaje',1000); 
            $table->string('comentario',1000); 
            $table->timestamp('fecha_envio')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
