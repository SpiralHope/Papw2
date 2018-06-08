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

Route::get('/', function () {
    return view('layouts/app');
})->name('landing');







Route::get('/busqueda', function () {
    return view('busqueda');
});

Route::get('/busqueda/categoria/{id}', function ($id) {
    return view('busqueda');
});


Route::get('producto/details/{producto?}', function ($producto = '') {
    return view('detalle', compact('producto') );
});

Auth::routes();

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
