<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Usuario;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $entrada = $this->faker->datetimeBetween('now', '+1 month');
        $salida = $this->faker->datetimeBetween($entrada, $entrada->format('d-m-Y') . ' +10 days');
        return [
            'usuario_id' => Usuario::factory(),
            'habitacion_id' => Habitacion::factory(),
            'hotel_id' => function (array $attributes) {
                return Habitacion::find($attributes['habitacion_id'])->hotel_id;
            },
            'fecha_entrada' => $entrada,
            'fecha_salida' => $salida,
            'precio_total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
