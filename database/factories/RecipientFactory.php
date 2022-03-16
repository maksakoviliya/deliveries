<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipient>
 */
class RecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => "7" . $this->faker->randomNumber(9),
            'address' => $this->faker->address(),
            'product_name' => $this->faker->sentence(mt_rand(1, 4)),
            'user_id' => mt_rand(1, 9),
        ];
    }
}
