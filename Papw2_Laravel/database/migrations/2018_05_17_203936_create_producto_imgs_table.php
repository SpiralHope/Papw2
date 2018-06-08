<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_imgs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_producto')->unsigned();
            $table->string('img_url');

            $table->foreign('id_producto')->references('id')->on('productos');
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
        Schema::dropIfExists('producto_imgs');
    }
}
