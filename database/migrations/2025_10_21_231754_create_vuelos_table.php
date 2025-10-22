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
        Schema::create('vuelos', function (Blueprint $table) {
            $table->id('id_vuelo');
            $table->date('fecha_vuelo');
            $table->time('hora');
            $table->unsignedBigInteger('id_origen')->nullable();
            $table->unsignedBigInteger('id_destino')->nullable();
            $table->unsignedBigInteger('id_avion')->nullable();
            $table->unsignedBigInteger('id_precio')->nullable();
            $table->timestamps();
            
            $table->foreign('id_origen')->references('id_lugar')->on('lugares');
            $table->foreign('id_destino')->references('id_lugar')->on('lugares');
            $table->foreign('id_avion')->references('id_avion')->on('modelo_avion');
            $table->foreign('id_precio')->references('id_precio')->on('precios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vuelos');
    }
};
