<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvioSunatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_sunat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documento_venta_id');
            $table->foreign('documento_venta_id')->references('id')->on('documento_venta')->onDelete('cascade');
            $table->json('cdr_response')->nullable();
            $table->mediumText('id_response')->nullable();
            $table->mediumText('message_response')->nullable();
            $table->mediumText('codigo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->enum('estado',['ACEPTADO','RECHAZADO']);
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
        Schema::dropIfExists('envio_sunat');
    }
}
