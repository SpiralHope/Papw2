<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_categoria')->unsigned();
            $table->integer('id_usuario')->unsigned();
            $table->integer('ranking')->default(-1);
            $table->integer('reviews')->default(0);;

            $table->string('nombre');
            $table->decimal('precio', 12, 2);
            
            $table->string('desc_corta');
            $table->string('detalles');

            $table->boolean('on_review')->default(false);
            $table->boolean('valid')->default(false);

            $table->foreign('id_categoria')->references('id')->on('categorias');
            $table->foreign('id_usuario')->references('id')->on('users');

            $table->softDeletes();
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
        Schema::dropIfExists('productos');
    }
}
