<?php
namespace Database\Factories;

use App\Models\Adresse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adresses>
 */
class AdresseFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à cette factory.
     */
    protected $model = Adresse::class;

    /**
     * Définition de l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rue'    => fake()->streetName(),
            'numéro' => fake()->buildingNumber(), // Génère un chiffre (ex: 12, 45A)
            'ville'  => fake()->city(),
            'cp'     => fake()->postcode(), // "cp" pour code postal
            'pays'   => 'Belgique', // Défaut pour ton projet bien-être
            'boîte'  => fake()->optional(0.3)->numerify('B-##'), // 30% de chance d'avoir une boîte (ex: B-12)
        ];
    }
}