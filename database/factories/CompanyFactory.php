<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => mt_rand(1, 9),
            'type' => $this->faker->randomElement(['ip', 'ooo']),
            'title' => $this->faker->sentence(mt_rand(1, 4)),
            'long_title' => $this->faker->sentence(mt_rand(3, 8)),
            'opf' => $this->faker->randomNumber(),
            'inn' => $this->faker->randomNumber(),
            'ogrn' => $this->faker->randomNumber(),
            'okpo' => $this->faker->randomNumber(),
            'address' => $this->faker->address(),
            'oktmo' => $this->faker->randomNumber(),
            'okved' => $this->faker->randomNumber(),
            'pfr' => $this->faker->randomNumber(),
            'rs' => $this->faker->randomNumber(),
            'bank' => $this->faker->title(),
            'bank_address' => $this->faker->address(),
            'bik' => $this->faker->randomNumber(),
            'ks' => $this->faker->randomNumber(),
            'phone' => $this->faker->phoneNumber(),
            'mail' => $this->faker->email(),
            'kpp' => $this->faker->randomNumber(),
            'okato' => $this->faker->randomNumber(),
        ];
    }
}
