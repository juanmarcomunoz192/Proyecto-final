<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    // Variable estática para llevar el control de cuáles hemos entregado
    protected static array $hotelesUsados = [];

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $hotelesReales = [
            ['nombre' => 'Hotel Riu Plaza España', 'direccion' => 'Calle de Gran Vía, 84, 28013', 'ciudad' => 'Madrid'],
            ['nombre' => 'Hotel Majestic Barcelona', 'direccion' => 'Passeig de Gràcia, 68, 08007', 'ciudad' => 'Barcelona'],
            ['nombre' => 'Hotel Alfonso XIII', 'direccion' => 'Calle San Fernando, 2, 41004', 'ciudad' => 'Sevilla'],
            ['nombre' => 'Hotel Palafox', 'direccion' => 'Calle de la Marquesa de Casa Jiménez, s/n, 50004', 'ciudad' => 'Zaragoza'],
            ['nombre' => 'Hotel Las Arenas Balneario', 'direccion' => 'Carrer d\'Eugènia Viñes, 22, 46011', 'ciudad' => 'Valencia'],
            ['nombre' => 'Gran Hotel Miramar', 'direccion' => 'Paseo de Reding, 22, 29016', 'ciudad' => 'Málaga'],
            ['nombre' => 'Hotel Meliá Madrid Princesa', 'direccion' => 'Calle de la Princesa, 27, 28008', 'ciudad' => 'Madrid'],
            ['nombre' => 'Hotel W Barcelona', 'direccion' => 'Plaça Rosa Del Vents, 1, 08039', 'ciudad' => 'Barcelona'],
            ['nombre' => 'Hotel Giralda Center', 'direccion' => 'Calle Juan de Mata Carriazo, 6, 41018', 'ciudad' => 'Sevilla'],
            ['nombre' => 'The Westin Valencia', 'direccion' => 'Carrer d\'Amadeu de Savoia, 16, 46010', 'ciudad' => 'Valencia'],
        ];

        // Filtramos para obtener solo los que no hemos usado todavía
        $disponibles = array_filter($hotelesReales, function ($h) {
            return !in_array($h['nombre'], self::$hotelesUsados);
        });

        // Si se acaban los 10 únicos, reiniciamos el ciclo para no dar error
        if (empty($disponibles)) {
            self::$hotelesUsados = [];
            $disponibles = $hotelesReales;
        }

        // Elegimos uno de los disponibles
        $hotel = $this->faker->randomElement($disponibles);

        // Lo marcamos como usado
        self::$hotelesUsados[] = $hotel['nombre'];

        return [
            'nombre' => $hotel['nombre'],
            'direccion' => $hotel['direccion'] . ', España',
            'ciudad' => $hotel['ciudad']
        ];
    }
}
