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
        Schema::table('vuelos', function (Blueprint $table) {
            $table->time('hora_llegada')->nullable()->after('hora');
            $table->string('duracion', 20)->nullable()->after('hora_llegada');
            $table->boolean('directo')->default(true)->after('duracion');
            $table->boolean('wifi')->default(false)->after('directo');
            $table->boolean('reembolsable')->default(false)->after('wifi');
            $table->string('codigo_vuelo', 10)->nullable()->after('reembolsable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vuelos', function (Blueprint $table) {
            $table->dropColumn(['hora_llegada', 'duracion', 'directo', 'wifi', 'reembolsable', 'codigo_vuelo']);
        });
    }
};
