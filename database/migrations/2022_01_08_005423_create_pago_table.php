<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documento_venta_id');
            $table->foreign('documento_venta_id')->references('id')->on('documento_venta')->onDelete('cascade');
            $table->decimal('efectivo');
            $table->decimal('transferencia');
            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago')->onDelete('cascade');
            $table->string('url_imagen')->nullable();
            $table->string('nombre_imagen')->nullable();
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
        Schema::dropIfExists('pago');
    }
}
