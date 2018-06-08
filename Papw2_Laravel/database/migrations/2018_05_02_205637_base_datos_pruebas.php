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

        /*
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
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('producto-imagenes');
        Schema::dropIfExists('transaccion');
        Schema::dropIfExists('transaccion-detalle');
        Schema::dropIfExists('review');
        */

    }
}





/*
////////////

    DB::table('categorias')->insert([
            ['nombre' => "Ropa y Calzado"],
            ['nombre' => "Accesorios y Joyeria"],
            ['nombre' => "Pinturas y Esculturas"],
            ['nombre' => "Fiestas y Eventos"],
            ['nombre' => "Hogar y Decoracion"],
            ['nombre' => "Herramientas y Utilidades"]
        ]);

        DB::table('usuario')->insert([
            'correo' => "hugo@mail.com",
            'password' => "123456789",
            'biografia' => "Solo soy un chico, o chica, un helicoptero, ya no se que soy :sad-face:",
            'rango' => "General",
            'ventas-totales' =>  0,
            'img' => "/img/user.jpg"
        ]);

        DB::table('producto')->insert([
            'id-categoria' => 1,
            'id_usuario' => 1,
            'ranking' => 0,
            'reviews' => 0,
            'activo' =>  true,
            'nombre' => "Pinturas Misticas",
            'precio' => 179,
            'desc-corta' => "Del los reinos mas lejanos",
            'detalles' => "Medida 19cmx25cm"
        ]);


        DB::table('producto-imagenes')->insert([
            [
                'id-producto' => 1,
                'img-url' => "/img/cool1.jpg",
                'principal' => true
            ],
            [
                'id-producto' => 1,
                'img-url' => "/img/Back01.jpg",
                'principal' => false
            ],
            [
                'id-producto' => 1,
                'img-url' => "/img/cool1.jpg",
                'principal' => false
            ]
        ]);

*/