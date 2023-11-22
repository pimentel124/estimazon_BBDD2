<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
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
            'image_url' => fake()->imageUrl(),
            'status' => 'out_of_stock'
            //'category' => Category::where('parent_category', null)->inRandomOrder()->first()->id
        ];
        
    }
}
