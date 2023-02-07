<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'apellido' => $this->faker->lastName(),
            'dni' => $this->faker->unique()->randomNumber(),
            'ruc' => $this->faker->unique()->randomNumber(),
            'celular' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'puntos' => $this->faker->randomElement([0, 20, 50, 70, 80, 100, 500]),
            'rol' => "cliente",
        ];
    }
}
