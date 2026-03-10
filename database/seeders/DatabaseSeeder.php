<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Factura;
use App\Models\Habitacion;
use App\Models\Hotel;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory()->count(10)->create();
        Hotel::factory()->count(10)->has(Habitacion::factory()->count(8), 'habitaciones')->create();
        Reserva::factory()->count(10)->create()->each(function ($reserva) {
            Factura::factory()->create(['reserva_id' => $reserva->id]);
        });
    }
}
