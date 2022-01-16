<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleDocumentoCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_documento_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documento_compra_id');
            $table->foreign('documento_compra_id')->references('id')->on('documento_compra')->onDelete('cascade');
            $table->unsignedBigInteger('insumo_id');
            $table->foreign('insumo_id')->references('id')->on('insumo')->onDelete('cascade');
            $table->decimal('cantidad');
            $table->decimal('precio');
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
        Schema::dropIfExists('detalle_documento_compra');
    }
}
