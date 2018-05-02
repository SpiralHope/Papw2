<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseDatosPruebas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correo',250);
            $table->string('password',250);
            $table->string('biografia',250);
            $table->string('rango',250);
            $table->integer('ventas-totales');
            $table->string('img',250);
            $table->timestamps();
        });
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',250);
            $table->timestamps();
        });
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id-categoria');
            $table->integer('id_usuario');
            $table->integer('ranking');
            $table->integer('reviews');

            $table->boolean('activo');
            $table->string('nombre',250);
            $table->decimal('precio', 12, 2);
            $table->string('desc-corta',250);
            $table->string('detalles',250);
            $table->timestamps();
        });
        Schema::create('producto-imagenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id-producto');
            $table->string('img-url',250);
            $table->boolean('principal');
            $table->timestamps();
        });
        Schema::create('transaccion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id-usuario');
            $table->boolean('completado');
            $table->timestamps();
        });
        Schema::create('transaccion-detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id-transaccion');
            $table->integer('id-producto');
            $table->integer('precio-compra');
            $table->integer('cant');

            $table->timestamps();
        });
        Schema::create('review', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id-producto');
            $table->integer('id-usuario');
            $table->integer('ranking');
            $table->boolean('ranking-dado');
            $table->string('comentario',250);
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
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('producto-imagenes');
        Schema::dropIfExists('transaccion');
        Schema::dropIfExists('transaccion-detalle');
        Schema::dropIfExists('review');

    }
}
