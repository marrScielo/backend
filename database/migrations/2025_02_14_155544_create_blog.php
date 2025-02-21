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
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('idBlog');
            $table->unsignedInteger('idEspecialidad');
            $table->string('tema', 100);
            $table->text('contenido');
            $table->string('imagen', 200);
            $table->unsignedInteger('idPsicologo');
            $table->timestamp('fecha_publicado')->useCurrent();

            $table->foreign('idPsicologo')->references('idPsicologo')->on('psicologos')->onDelete('cascade');
            $table->foreign('idEspecialidad')->references('idEspecialidad')->on('especialidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('categorias');
    }
};
