<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuario');
            $table->date('fecha_pago');
            $table->date('fecha_vencimiento');
            $table->date('fecha_inicio_mensualidad');
            $table->date('fecha_termino_mensualidad');
            $table->integer('cantidad_clases');
            $table->enum('medio_pago',['efectivo', 'transferencia', 'e-pago']);
            $table->boolean('primera_mensualidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
