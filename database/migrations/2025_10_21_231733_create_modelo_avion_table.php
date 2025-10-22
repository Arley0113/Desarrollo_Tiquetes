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
        Schema::create('modelo_avion', function (Blueprint $table) {
            $table->id('id_avion');
            $table->string('nombre_avion', 100);
            $table->integer('capacidad');
            $table->string('serial', 50)->unique();
            $table->unsignedBigInteger('id_aeropuerto')->nullable();
            $table->timestamps();
            
            $table->foreign('id_aeropuerto')->references('id_aeropuerto')->on('aeropuerto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo_avion');
    }
};
