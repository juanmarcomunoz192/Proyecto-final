<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Importante
use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cada vez que se cargue la vista 'habitaciones', inyecta los tipos
        View::composer('habitaciones', function ($view) {
            $view->with('tiposHabitaciones', Habitacion::distinct()->pluck('tipo'));
        });
        View::composer('admin_habitaciones_create', function ($view) {
            $view->with('tiposHabitaciones', Habitacion::distinct()->pluck('tipo'));
        });
        View::composer('admin_habitaciones_create', function ($view) {
            $view->with('hoteles_id', Habitacion::distinct()->pluck('hotel_id'));
        });
        View::composer('admin_facturas_create', function ($view) {
            $view->with('reserva_ids', Reserva::distinct()->pluck('id'));
        });
        // En el método boot() de AppServiceProvider.php

        View::composer('admin_reservas_create', function ($view) {
            $view->with('hoteles_id', \App\Models\Hotel::pluck('id'));
            $view->with('habitaciones_id', \App\Models\Habitacion::pluck('id'));
            $view->with('usuarios_id', \App\Models\User::pluck('id'));
        });
        Paginator::useBootstrapFive();
    }
}
