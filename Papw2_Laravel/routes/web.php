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
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});




Route::get('/busqueda', function () {
    return view('busqueda');
});

Route::get('/busqueda/categoria/{id}', function ($id) {
    return view('busqueda');
});


Route::get('producto/details/{producto?}', function ($producto = '') {
    return view('detalle', compact('producto'));
});