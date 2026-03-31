<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Adresse;
use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
    Adresse::create([
                'id' => 1, // On force aussi l'ID de l'adresse
                'rue' => 'Rue de Administration',
                'numéro' => '1',
                'ville' => 'Bruxelles',
                'cp' => '1000',
                'pays' => 'Belgique',
            ]);

    User::create([
        'id' => 1, // On force aussi l'ID de l'adresse
        'nom' => 'Admin',
        'prenom' => 'System',
        'email' => 'admin@test.com',
        'password' => bcrypt('password123'),
        'role' => 'ADMIN',
       'adresse_id'=> 1,
    ]);

     Adresse::create([
                'id' => 2, // On force aussi l'ID de l'adresse
                'rue' => 'Rue Garibaldi',
                'numéro' => '1',
                'ville' => 'Lyon',
                'cp' => '69007',
                'pays' => 'France',
            ]);
    

    // 2. Création de l'Utilisateur Standard (Client)
    
    User::create([
        'id' => 2, // On force aussi l'ID de l'adresse
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'user@test.com',
        'password' => bcrypt('password123'),
        'role' => 'USER',
        'adresse_id'=> 2,
    ]);

    
        // 1. Création des 5 villes pour tes tests
    $villes = ['Paris', 'Lyon', 'Marseille', 'Lille', 'Bordeaux'];

    // 2. Création des 5 catégories fixes
    $nomsCategories = ['Massages relaxants', 'Soins énergétiques', 'Yoga & Méditation', 'Naturopathie', 'Réflexologie','Spa & Sauna'];

    foreach ($nomsCategories as $index => $nom) {
        $categorie = \App\Models\Categorie::create([
            'nom' => $nom,
            'description' => "Description pour $nom",
            'mise_en_avant' => ($nom === 'Massages relaxants'), // Service du mois
            'valide' => true,
        ]);

         // 2. Créer l'adresse d'abord (nécessaire pour la FK)
    $adresse = \App\Models\Adresse::create([
        'rue' => 'Rue de la Paix',
        'numéro' => rand(1, 100),
        'ville' => $villes[$index], // Utilise une ville différente à chaque tour
        'cp' => '1000',
        'pays' => 'Belgique',
    ]);
        // 3. Création d'un prestataire par catégorie dans une ville différente
        $prestataire = \App\Models\User::factory()->create([
            'nom' => "Pro $nom",
            'email' => "pro.$index@test.com",
            'role' => 'PROVIDER',
            'password' => bcrypt('password123'),
        ]);

        // 4. Lier le prestataire à sa catégorie (table pivot)
        $prestataire->categories()->attach($categorie->id);
    }

        User::factory(15)->create();
        Adresse::factory(50)->create();
        Categorie::factory(5)->create();
   

    }
}
