<?php

namespace Database\Factories;

use App\Models\Reserva;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reserva_id' => Reserva::factory(),
            'fecha' => now(),
            'precio_total' => function (array $attributes) {
                return \App\Models\Reserva::find($attributes['reserva_id'])->precio_total;
            }
        ];
    }
}
