<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['car', 'foot']),
            'delivery_from' => $this->faker->dateTime(),
            'delivery_to' => $this->faker->dateTime(),
            'assessed_value' => $this->faker->randomFloat(2, 0, 1000),
            'weight' => $this->faker->randomNumber(4),
            'cod' => $this->faker->randomElement([true, false]),
            'payment_type' => $this->faker->randomElement(['card', 'cash']),
            'user_id' => mt_rand(1, 10),
            'status' => $this->faker->randomElement(['processing', 'work', 'delivered', 'undelivered']),
            'comment' => $this->faker->realText()
        ];
    }
}