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


		DB::table('users')->insert([
            'name' => "Hugo",
            'email' => "hugo_incorporated@hotmail.com",
            'password' => Hash::make('123456'),
            'biografia' => "Solo soy un chico, o chica, un helicoptero, ya no se que soy :sad-face:",
            'role' =>  "admin",
        ]);

        DB::table('users')->insert([
            'name' => "Samhara",
            'email' => "Samy@hotmail.com",
            'password' => Hash::make('123456789'),
            'biografia' => "NoImporta",
            'role' =>  "vendedor",
        ]);


        DB::table('productos')->insert([
            'id_categoria' => 1,
            'id_usuario' => 2,
            'ranking' => 0,
            'nombre' => 'Artesania Ansestral',
            'precio' => 250.0,
            'desc_corta' => "Mhe",
            'detalles' => "Mhe"
        ]);

        DB::table('producto_imgs')->insert([
            [ 'id_producto' => 1, 'img_url' => 'testImg/01.png' ],
            [ 'id_producto' => 1, 'img_url' => 'testImg/02.png' ],
            [ 'id_producto' => 1, 'img_url' => 'testImg/03.png' ],
            [ 'id_producto' => 1, 'img_url' => 'testImg/04.png' ],
        ]);

        

            
    }
}
