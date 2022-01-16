<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedor')->onDelete('cascade');
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->string('ruta_imagen')->nullable();
            $table->string('nombre_imagen')->nullable();
            $table->unsignedBigInteger('tipo_documento_id');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento')->onDelete('cascade');
            $table->string('numeracion');
            $table->dateTime('fecha_emision');
            $table->dateTime('fecha_entrega');
            $table->enum('igv',['Si','No'])->default('Si');
            $table->decimal('cantidad_igv')->default(0.18);
            $table->enum('modo_compra',['CONTADO','CREDITO'])->default('CONTADO');
            $table->decimal('total')->default(0);
            $table->enum('tipo_moneda',['SOLES','DOLARES'])->default('SOLES');
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
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
        Schema::dropIfExists('documento_compra');
    }
}
