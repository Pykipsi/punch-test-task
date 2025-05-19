<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'telegram_id' => (string) $this->faker->unique()->numberBetween(100000000, 999999999),
            'subscribed' => $this->faker->boolean(80),
        ];
    }
}
