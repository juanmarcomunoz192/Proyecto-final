<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/carrito', function () {
    return view('carrito');
});

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/habitaciones', function () {
    return view('habitaciones');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/servicios', function () {
    return view('servicios');
});
