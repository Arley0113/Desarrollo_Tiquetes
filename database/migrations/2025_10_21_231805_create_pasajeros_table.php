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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id('id_pasajero');
            $table->unsignedBigInteger('id_reserva')->nullable();
            $table->string('nombre_pasajero', 100);
            $table->string('documento', 30)->nullable();
            $table->boolean('es_acompanante')->default(false);
            $table->timestamps();
            
            $table->foreign('id_reserva')->references('id_reserva')->on('reservas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
