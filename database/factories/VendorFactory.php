<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->name(),
            'description' => fake()->text(),
            'address' =>fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email'=> fake()->unique()->safeEmail(),
            'nif' => fake()->randomNumber(9).fake()->randomLetter(),
        ];
    }
}
