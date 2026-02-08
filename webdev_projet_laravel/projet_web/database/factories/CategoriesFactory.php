<?php
namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    protected $model = Categories::class;

    public function definition(): array
    {
        // Liste réaliste pour ton projet bien-être
        $nom = fake()->unique()->randomElement([
            'Massages relaxants', 
            'Soins énergétiques', 
            'Yoga & Méditation', 
            'Naturopathie', 
            'Réflexologie', 
            'Spa & Sauna'
        ]);

        return [
            'nom' => $nom,
            'description' => fake()->paragraph(2),
            'mise_en_avant' => fake()->boolean(25), // 25% de chance d'être "true"
            'valide' => true, // On les valide par défaut pour tes tests
        ];
    }
}

