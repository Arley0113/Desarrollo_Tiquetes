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
        Schema::create('asientos', function (Blueprint $table) {
            $table->id('id_asiento');
            $table->string('numero_asiento', 10);
            $table->unsignedBigInteger('id_avion')->nullable();
            $table->timestamps();
            
            $table->foreign('id_avion')->references('id_avion')->on('modelo_avion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asientos');
    }
};
