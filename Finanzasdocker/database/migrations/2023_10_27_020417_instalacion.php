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
        //tabla de ingresos
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id(); // Campo de ID autoincremental
            $table->string('codigo')->comment('codigo indicado por el usuario');
            $table->string('motivo');
            $table->integer('monto')->nullable();
            $table->integer('estado')->default(1)->nullable()->comment('0 eliminada 1 activa');
            $table->date('fecha')->comment('fecha indicada por el usuario');
            $table->date('fecha_registro')->timestamps()->comment('fecha indicada por el sistema');
            $table->string('fecha_eliminacion')->nullable();
            $table->integer('tipo')->comment('1 para ingreso 2 para egreso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //tabla ingresos
        Schema::dropIfExists('transacciones');
    }
};
