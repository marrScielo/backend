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
        Schema::create('enfermedad', function (Blueprint $table) {
            $table->increments('idEnfermedad'); 
            $table->string('nombreEnfermedad', 100)->unique(); 
            $table->string('DSM5', 50)->unique(); 
            $table->string('CEA10',50)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
