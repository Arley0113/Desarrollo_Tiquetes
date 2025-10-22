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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_reserva')->nullable();
            $table->string('nombre_titular', 100)->nullable();
            $table->string('tipo_documento', 20)->nullable();
            $table->string('documento', 30)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->enum('medio_pago', ['Tarjeta de crédito', 'Tarjeta débito', 'PSE'])->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->datetime('fecha_pago')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_reserva')->references('id_reserva')->on('reservas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
