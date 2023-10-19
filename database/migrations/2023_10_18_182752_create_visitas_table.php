<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corretor_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('imovel_id');
            $table->dateTime('data_visita');
            $table->enum('status', ['Agendado', 'Não realizado', 'Realizado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
