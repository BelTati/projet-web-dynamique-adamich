<?php
namespace Database\Factories;

use App\Models\Adresses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilisateursFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'adresse_id' => Adresses::factory(), 
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'tva' => fake()->optional(0.3)->numerify('BE ####.###.###'), // Uniquement pour certains
            'telephone_mobile' => fake()->phoneNumber(),
            'site_web' => fake()->optional(0.2)->url(),
            'nombre_tentatives_connexion' => 0,
            'langue' => fake()->randomElement(['fr', 'en', 'nl']),
            'role' => fake()->randomElement(['ADMIN', 'USER', 'PROVIDER', 'TEMP']),
            'est_banni' => fake()->boolean(5), // 5% de chance d'être banni
            'inscription_confirmation_at' => now(),
            'newsletter' => fake()->boolean(),
        ];
    }

    // État spécifique pour créer un Admin rapidement
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'ADMIN',
            'email' => 'admin@prj-web.be',
        ]);
    }
}