<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tornaguias', function (Blueprint $table) {
            $table->id();
            $table->string('yacimiento');
            $table->string('destino');
            $table->string('contratista');
            $table->integer('cantidad');
            $table->string('minerales');
            $table->string('tipoManterial');
            $table->string('autorizado');
            $table->unsignedBigInteger('transporte_id');
            $table->foreign('transporte_id')->references('id')->on('transportes');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('contratista_id');
            $table->foreign('contratista_id')->references('id')->on('contratistas');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tornaguias');
    }
};
