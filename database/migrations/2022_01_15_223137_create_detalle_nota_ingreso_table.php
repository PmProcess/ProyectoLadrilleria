<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleNotaIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_nota_ingreso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_ingreso_id');
            $table->foreign('nota_ingreso_id')->references('id')->on('nota_ingreso')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade');
            $table->decimal('cantidad');
            $table->date('fecha_vencimiento');
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
        Schema::dropIfExists('detalle_nota_ingreso');
    }
}
