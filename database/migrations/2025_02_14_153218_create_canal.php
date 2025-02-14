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
        Schema::create('canal', function (Blueprint $table) {
            $table->increments('canal_id')->unique(); 
            $table->string('name',100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
