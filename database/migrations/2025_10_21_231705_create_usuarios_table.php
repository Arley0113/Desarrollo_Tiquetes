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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('nombres', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->string('tipo_documento', 20)->nullable();
            $table->string('documento', 30)->unique();
            $table->boolean('condicion_infante')->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('correo', 100)->unique()->nullable();
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->enum('estado_usuario', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
            
            $table->foreign('id_rol')->references('id_rol')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
