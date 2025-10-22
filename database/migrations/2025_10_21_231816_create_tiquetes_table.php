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
        Schema::create('tiquetes', function (Blueprint $table) {
            $table->id('id_tiquete');
            $table->string('codigo', 50)->unique();
            $table->string('detalle_tiquete', 255)->nullable();
            $table->unsignedBigInteger('id_reserva')->nullable();
            $table->unsignedBigInteger('id_vuelo')->nullable();
            $table->unsignedBigInteger('id_asiento')->nullable();
            $table->unsignedBigInteger('id_precio')->nullable();
            $table->datetime('fecha_emision')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_reserva')->references('id_reserva')->on('reservas');
            $table->foreign('id_vuelo')->references('id_vuelo')->on('vuelos');
            $table->foreign('id_asiento')->references('id_asiento')->on('asientos');
            $table->foreign('id_precio')->references('id_precio')->on('precios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiquetes');
    }
};
