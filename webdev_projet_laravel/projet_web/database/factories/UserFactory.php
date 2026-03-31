<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Adresse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'adresse_id' => Adresse::factory(), 
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'tva' => fake()->optional(0.3)->numerify('BE ####.###.###'), // Uniquement pour certains
            'telephone_mobile' => fake()->phoneNumber(),
            'site_web' => fake()->optional(0.2)->url(),
            'nombre_tentatives_connexion' => 0,
            'langue' => fake()->randomElement(['fr', 'en', 'nl']),
            'role' => fake()->randomElement(['ADMIN', 'USER', 'PROVIDER', 'TEMP']),
            'est_banni' => fake()->boolean(5), // 5% de chance d'être banni
            'email_verified_at' => now(),
            'newsletter' => fake()->boolean(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'ADMIN',
            'email' => 'admin@prj-web.be',
        ]);
    }
}
