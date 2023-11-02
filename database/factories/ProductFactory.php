<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'price' =>fake()->randomFloat(2,1,100),
            'image_url' => fake()->imageUrl(),
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
        ];
        
    }
}
