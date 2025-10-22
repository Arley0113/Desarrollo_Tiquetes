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
        Schema::create('aeropuerto', function (Blueprint $table) {
            $table->id('id_aeropuerto');
            $table->string('nombre', 100);
            $table->string('detalle', 255)->nullable();
            $table->unsignedBigInteger('id_lugar')->nullable();
            $table->timestamps();
            
            $table->foreign('id_lugar')->references('id_lugar')->on('lugares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeropuerto');
    }
};
