<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarif>
 */
class TarifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'foot_today' => $this->faker->randomNumber(3),
            'foot' => $this->faker->randomNumber(3),
            'car_today' => $this->faker->randomNumber(3),
            'car' => $this->faker->randomNumber(3),
        ];
    }
}
