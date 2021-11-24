<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeracionConteoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeracion_conteo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numeracion_id');
            $table->foreign('numeracion_id')->references('id')->on('numeracion')->onDelete('cascade');
            $table->string('correlativo');
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
        Schema::dropIfExists('numeracion_conteo');
    }
}
