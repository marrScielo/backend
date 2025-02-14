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
        Schema::create('tipocita', function (Blueprint $table) {
            $table->increments('tipoCita_id')->unique(); 
            $table->string('name',100);
            $table->integer('tiempoCita'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
