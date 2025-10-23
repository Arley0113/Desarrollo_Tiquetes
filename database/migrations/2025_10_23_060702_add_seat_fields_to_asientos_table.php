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
        Schema::table('asientos', function (Blueprint $table) {
            $table->integer('fila')->after('numero_asiento');
            $table->string('columna', 2)->after('fila');
            $table->enum('tipo_asiento', ['normal', 'extra', 'emergencia'])->default('normal')->after('columna');
            $table->enum('estado', ['disponible', 'ocupado', 'seleccionado'])->default('disponible')->after('tipo_asiento');
            $table->decimal('precio_adicional', 10, 2)->default(0)->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asientos', function (Blueprint $table) {
            $table->dropColumn(['fila', 'columna', 'tipo_asiento', 'estado', 'precio_adicional']);
        });
    }
};
