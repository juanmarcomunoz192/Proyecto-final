<?php

use App\Http\Controllers\FacturasController;
use App\Http\Controllers\HabitacionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelesController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*RUTAS DE HOTELES */
Route::get('/hoteles', [HotelesController::class, 'index']);
Route::post('/hoteles/store', [HotelesController::class, 'store']);
Route::get('/hoteles/show/{id}', [HotelesController::class, 'show']);
Route::put('/hoteles/update/{id}', [HotelesController::class, 'update']);
Route::put('/hoteles/edit/{id}', [HotelesController::class, 'edit']);
Route::delete('/hoteles/destroy/{id}', [HotelesController::class, 'destroy']);

/*RUTAS DE USUARIO */
Route::get('/usuario', [UsuarioController::class, 'index']);
Route::post('/usuario/store', [UsuarioController::class, 'store']);
Route::get('/usuario/show/{id}', [UsuarioController::class, 'show']);
Route::put('/usuario/update/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuario/destroy/{id}', [UsuarioController::class, 'destroy']);

/*RUTAS DE HABITACIÓN*/
Route::get('/habitaciones', [HabitacionesController::class, 'index']);
Route::post('/habitaciones/store', [HabitacionesController::class, 'store']);
Route::get('/habitaciones/show/{id}', [HabitacionesController::class, 'show']);
Route::put('/habitaciones/update/{id}', [HabitacionesController::class, 'update']);
Route::delete('/habitaciones/destroy/{id}', [HabitacionesController::class, 'destroy']);

/*RUTAS DE Facturas*/
Route::get('/facturas', [FacturasController::class, 'index']);
Route::post('/facturas/store', [FacturasController::class, 'store']);
Route::get('/facturas/show/{id}', [FacturasController::class, 'show']);
Route::put('/facturas/update/{id}', [FacturasController::class, 'update']);
Route::delete('/facturas/destroy/{id}', [FacturasController::class, 'destroy']);
