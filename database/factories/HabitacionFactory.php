<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habitacion>
 */
class HabitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => \App\Models\Hotel::factory(),
            'numero' => $this->faker->bothify('Hab-###'),
            'tipo' => $this->faker->randomElement(['Simple', 'Doble', 'Suite', 'deluxe']),
            'precio' => $this->faker->randomFloat(2, 50, 300),
            'esta_disponible' => true,
        ];
    }
}
