<?php

use App\Enums\UserRole;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservasController;
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
    return view('login');
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
})->name('login');

Route::get('/servicios', function () {
    return view('servicios');
});


Route::post('/habitacion', [HabitacionesController::class, 'filtrado']);
Route::get('/habitacion', [HabitacionesController::class, 'filtrado']);
Route::post('/agregar', [ReservasController::class, 'agregar'])->name('reserva.agregar');

//registro urls

Route::middleware('guest')->group(function () {
    Route::post('/registro', [RegisterController::class, 'register'])->name('registro.post');
    Route::post('/login', [RegisterController::class, 'login'])->name('login.post');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
    Route::get('/carrito', function () {
        return view('carrito');
    })->name("carrito");
});
Route::middleware(['role:'.UserRole::User->value])->group(function () {
    
});

// ------------------------------------------
// ZONA SOLO PARA ADMINISTRADORES ('admin')
// ------------------------------------------
Route::middleware(['role:'.UserRole::Admin->value])->group(function () {
    
    // Ejemplo: Panel de control del hotel
    // Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // Route::get('/admin/habitaciones/crear', [HabitacionesController::class, 'create']);
});
