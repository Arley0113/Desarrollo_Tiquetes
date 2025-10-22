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
        Schema::create('precios', function (Blueprint $table) {
            $table->id('id_precio');
            $table->decimal('precio_ida', 10, 2)->nullable();
            $table->decimal('precio_ida_vuelta', 10, 2)->nullable();
            $table->unsignedBigInteger('id_viaje')->nullable();
            $table->timestamps();
            
            $table->foreign('id_viaje')->references('id_viaje')->on('tipo_viaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};
