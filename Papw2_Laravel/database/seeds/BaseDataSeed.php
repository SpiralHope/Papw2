<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

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
        
    }
}
