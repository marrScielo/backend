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
            $table->increments('idTipoCita')->unique(); 
            $table->string('nombre',100); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
