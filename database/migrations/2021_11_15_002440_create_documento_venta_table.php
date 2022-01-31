<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_venta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('cotizacion_id')->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizacion')->onDelete('cascade');
            // $table->unsignedBigInteger('forma_pago_id');
            // $table->foreign('forma_pago_id')->references('id')->on('forma_pago')->onDelete('cascade');
            $table->unsignedBigInteger('correlativo_id');
            $table->foreign('correlativo_id')->references('id')->on('numeracion_conteo')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_documento_id');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento')->onDelete('cascade');
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_vencimiento');
            // $table->unsignedBigInteger('tipo_moneda_id');
            // $table->foreign('tipo_moneda_id')->references('id')->on('tipo_moneda')->onDelete('cascade');
            $table->decimal('total');
            $table->decimal('deuda');
            $table->string('url_qr')->nullable();
            $table->string('nombre_comprobante_archivo')->nullable();
            $table->string('url_comprobante_archivo')->nullable();
            $table->longText('hash')->nullable();
            $table->enum('estado_documento',['PENDIENTE','PAGADO','FALLO','EXITO'])->default('PENDIENTE');
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
        Schema::dropIfExists('documento_venta');
    }
}
