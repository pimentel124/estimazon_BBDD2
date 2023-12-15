<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * estableix l'estat predeterminat del model amb dades generades aleatòriament, 
     * incloent-hi un rol i un número d'identificació fiscal (NIF) ficticis
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role_id' => fake()->numberBetween(1, 3),
            'nif' => fake()->randomNumber(9).fake()->randomLetter(),
        ];
    }

    /**
     * Indica que l'adreça de correu electrònic de l'usuari no ha estat verificada en establir email_verified_at com a nul.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
