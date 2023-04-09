<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Remesa>
 */
class RemesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'codigo' => fake()->randomNumber(3),
            'nombre_cliente' => fake()->name(),
            'telefono' => fake()->phoneNumber(),
            'direccion' => fake()->address(),
            'municipio_id' => fake()->numberBetween(1, 15),
            'cantidad' => fake()->randomFloat(2, 50, 5000),
            'moneda_id' => fake()->numberBetween(1, 3),
            'comision' => 450,
            'estado' => false,
        ];
    }
}
