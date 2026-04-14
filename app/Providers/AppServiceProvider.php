<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Importante
use App\Models\Habitacion;
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
        Paginator::useBootstrapFive();
    }
}
