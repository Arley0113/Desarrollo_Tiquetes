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
        Schema::table('reservas', function (Blueprint $table) {
            // Agregar columna id_vuelo (nullable para compatibilidad con datos existentes)
            $table->unsignedBigInteger('id_vuelo')->nullable()->after('id_usuario');
            // FK a vuelos
            $table->foreign('id_vuelo')->references('id_vuelo')->on('vuelos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['id_vuelo']);
            $table->dropColumn('id_vuelo');
        });
    }
};