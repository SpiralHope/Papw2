<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('layouts/app');
})->name('landing');

*/

Route::get('/', 'DashboardController@verLanding')->name('landing');

Route::get('/landing', 'DashboardController@verLanding');



Route::get('/busqueda', 'BusquedaController@buscar')->name('busqueda');

/*
Route::get('/busqueda', function () {
    return view('busqueda');
})->name('busqueda');
*/


Route::get('/busqueda/categoria/{id}', function ($id) {
    return view('busqueda');
});


/*Producto*/
Route::get('producto/details/{producto?}', 'ProductoController@mostrarProducto')->name('producto');

/*Producto Comentario*/
Route::post('producto/comentar/{producto}', 'ProductoController@crearComentario');
Route::delete('producto/review/eliminar', 'ProductoController@eliminarComentario')->name('eliminarReview');
Route::put('producto/review/restaurar', 'ProductoController@restaurarComentario')->name('restaurarReview');

/*Producto-Revision para el admin*/
Route::get('producto/revision/{id}', 'ProductoController@verProductoRevision')->name('verReview');
Route::put('producto/revision/rechazar/{id}', 'ProductoController@rechazarProductoRevision')->name('rechazarProductoReview');
Route::put('producto/revision/validar/{id}', 'ProductoController@validarProductoRevision')->name('validarProductoReview');

/*Creacion y edicion*/
Route::get('producto/crear', 'ProductoController@verCrearProducto')->name('verCrearProducto');
Route::post('producto/crear', 'ProductoController@crearProducto')->name('crearProducto');
Route::get('producto/editar/{id}', 'ProductoController@verEdicionProducto')->name('verEdicionProducto');


Route::post('producto/editar', 'ProductoController@editarProducto')->name('editarProducto');

Route::post('producto/editar/revision/colocar', 'ProductoController@ponerRevisionProducto')->name('colocarRevisionProducto');
Route::post('producto/editar/revision/cancelar', 'ProductoController@quitarRevisionProducto')->name('cancelarRevisionProducto');


Route::post('producto/modImg', 'ProductoController@agregarImgProducto')->name('editarAgregarImg');
Route::post('producto/delImg', 'ProductoController@borrarImgProducto')->name('editarBorrarImg');



Route::get('producto/revisionVendedor/{id}', 'ProductoController@verReviewProducto')->name('verReviewProducto');


Route::get('dashboard', 'DashboardController@verDashboad')->name('dashboard');


Route::get('perfil/{id?}', 'PerfilController@verPerfil')->name('perfil');
Route::post('perfil/modificar', 'PerfilController@modificarPerfil')->name('modificarPerfil');


Route::get('public/images/{filename}', function ($filename)
{
    return redirect('storage/images/'.$filename);
    $path = storage_path('storage/images/'.$filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

//Carrito
Route::get('carrito', 'CarritoController@verCarrito')->name('carrito');
Route::post('carrito/agregar', 'CarritoController@agregarProducto')->name('agregarCarrito');
Route::post('carrito/eliminar', 'CarritoController@eliminarProducto')->name('eliminarCarrito');
Route::post('carrito/modificar', 'CarritoController@modificarProducto')->name('modificarCarrito');
Route::post('carrito/vaciar', 'CarritoController@vaciarCarrito')->name('vaciarCarrito');
Route::post('carrito/comprar', 'CarritoController@vaciarCarrito')->name('comprarCarrito');



//Dashboard
Route::get('dashboard', 'DashboardController@verDashboad')->name('dashboard');

Auth::routes();

Route::get('registerVendedor', 'Auth\RegisterController@showRegistrationFormVendedor')->name('register2');
Route::post('registerVendedor', 'Auth\RegisterController@registerVendedor');


/*
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/logout', function () {
    return view('register');
})->name('register');

*/







Route::get('/home', 'HomeController@index')->name('home');
