<?php

use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\RegisterController;
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
Route::get('/habitaciones', [HabitacionesController::class, 'index']);
Route::get('/login', function () {
    return view('login');
});

Route::get('/servicios', function () {
    return view('servicios');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/habitacion', [HabitacionesController::class, 'filtrado']);
Route::get('/habitacion', [HabitacionesController::class, 'filtrado']);
