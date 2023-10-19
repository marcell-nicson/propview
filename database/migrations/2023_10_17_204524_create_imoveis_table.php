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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('tipo_negocio', ['venda', 'aluguel']);
            $table->string('endereco');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imoveis');
    }
};
