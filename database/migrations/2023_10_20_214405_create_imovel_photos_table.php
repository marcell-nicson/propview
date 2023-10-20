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
        Schema::create('imovel_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imovel_id');  // Chave estrangeira para o imóvel associado
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('url');
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
        Schema::dropIfExists('imovel_photos');
    }
};
