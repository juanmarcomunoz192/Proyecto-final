<?php

use App\Enums\UserRole;
use App\Http\Controllers\AdminFacturasController;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\AdminHabitacionesController;
use App\Http\Controllers\AdminHotelesController;
use App\Http\Controllers\AdminReservasController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\FacturasController;
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
//registro urls

Route::middleware('guest')->group(function () {
    Route::post('/registro', [RegisterController::class, 'register'])->name('registro.post');
    Route::post('/login', [RegisterController::class, 'login'])->name('login.post');
});
Route::middleware('auth')->group(function () {
    Route::post('/agregar', [HabitacionesController::class, 'agregar'])->name('reserva.agregar');
    Route::get('/carrito', function () {
        return view('carrito'); // Nombre de tu archivo blade
    })->name('carrito.index');


    Route::get('/carrito/vaciar', function () {
        session()->forget('carrito');
        return redirect('/carrito')->with('success', 'Carrito vaciado');
    })->name('carrito.vaciar');

    Route::post('/carrito/confirmar', [ReservasController::class, 'confirmar'])->name('carrito.confirmar');
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
    Route::get('/carrito', function () {
        return view('carrito');
    })->name("carrito");
    Route::get('/facturas/descargar/{id}', [FacturasController::class, 'descargarPdf'])->name('factura.descargar');
});
Route::middleware(['role:' . UserRole::User->value])->group(function () {
    Route::get('/reservas', [ReservasController::class, 'index'])->name("reserva");
    Route::delete('/reservas/{id}', [ReservasController::class, 'borrar'])->name('reserva.borrar');
});

// ------------------------------------------
// ZONA SOLO PARA ADMINISTRADORES ('admin')
// ------------------------------------------
Route::middleware(['role:' . UserRole::Admin->value])->group(function () {
    Route::get('/admin', [AdminHabitacionesController::class, 'index'])->name("admin");
    Route::get('/admin/habitaciones', [AdminHabitacionesController::class, 'index'])->name("habitaciones");
    Route::get('/admin/hoteles', [AdminHotelesController::class, 'index'])->name("hoteles");
    Route::get('/admin/users', [AdminUsuarioController::class, 'index'])->name("users");
    Route::get('/admin/facturas', [AdminFacturasController::class, 'index'])->name("facturas");
    Route::get('/admin/reservas', [AdminReservasController::class, 'index'])->name("reservas");
    Route::get('/admin/reservas', [ReservasController::class, 'index'])->name("admin.reservas");
    //Eliminar
    Route::delete('/admin/habitaciones/{id}', [AdminHabitacionesController::class, 'borrar'])->name('habitaciones.borrar');
    Route::delete('/admin/hoteles/{id}', [AdminHotelesController::class, 'borrar'])->name('hoteles.borrar');
    Route::delete('/admin/reservas/{id}', [AdminReservasController::class, 'borrar'])->name('reservas.borrar');
    Route::delete('/admin/facturas/{id}', [AdminFacturasController::class, 'borrar'])->name('facturas.borrar');
    Route::delete('/admin/users/{id}', [AdminUsuarioController::class, 'borrar'])->name('users.borrar');
    //Actualizar
    // Esta ruta busca el ID y te lleva al formulario
    Route::get('/admin/habitaciones/{id}/edit', [AdminHabitacionesController::class, 'editar'])->name('habitaciones.editar');
    Route::put('/admin/habitaciones/{id}', [AdminHabitacionesController::class, 'actualizar'])->name('habitaciones.actualizar');
    Route::get('/admin/hoteles/{id}/edit', [AdminHotelesController::class, 'editar'])->name('hoteles.editar');
    Route::put('/admin/hoteles/{id}', [AdminHotelesController::class, 'actualizar'])->name('hoteles.actualizar');
    Route::get('/admin/users/{id}/edit', [AdminUsuarioController::class, 'editar'])->name('users.editar');
    Route::put('/admin/users/{id}', [AdminUsuarioController::class, 'actualizar'])->name('users.actualizar');
    Route::get('/admin/facturas/{id}/edit', [AdminFacturasController::class, 'editar'])->name('facturas.editar');
    Route::put('/admin/facturas/{id}', [AdminFacturasController::class, 'actualizar'])->name('facturas.actualizar');
    Route::get('/admin/reservas/{id}/edit', [AdminReservasController::class, 'editar'])->name('reservas.editar');
    Route::put('/admin/reservas/{id}', [AdminReservasController::class, 'actualizar'])->name('reservas.actualizar');



    // crear
    // Mostrar el formulario de creación
    Route::get('/admin/habitaciones/nuevo', [AdminHabitacionesController::class, 'crear'])->name('habitaciones.crear');

    // Procesar el guardado
    Route::post('/admin/habitaciones', [AdminHabitacionesController::class, 'guardar'])->name('habitaciones.guardar');

    Route::get('/admin/hoteles/nuevo', [AdminHotelesController::class, 'crear'])->name('hoteles.crear');
    Route::post('/admin/hoteles', [AdminHotelesController::class, 'guardar'])->name('hoteles.guardar');
    Route::get('/admin/users/nuevo', [AdminUsuarioController::class, 'crear'])->name('users.crear');
    Route::post('/admin/users', [AdminUsuarioController::class, 'guardar'])->name('users.guardar');
    Route::get('/admin/facturas/nuevo', [AdminFacturasController::class, 'crear'])->name('facturas.crear');
    Route::post('/admin/facturass', [AdminFacturasController::class, 'guardar'])->name('facturas.guardar');
    Route::get('/admin/reservas/nuevo', [AdminReservasController::class, 'crear'])->name('reservas.crear');
    Route::post('/admin/reservas', [AdminReservasController::class, 'guardar'])->name('reservas.guardar');
    // Ejemplo: Panel de control del hotel
    // Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // Route::get('/admin/habitaciones/crear', [HabitacionesController::class, 'create']);
});
