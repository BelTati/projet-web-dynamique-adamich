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
       // User::factory(15)->create();

        //User::factory()->create([
            //'name' => 'User',
            //'email' => 'User@example.com',
        //]);

        User::create([
            'id'=> 1, 
            'nom' => 'Admin',
            'prenom' => 'Tati',
            'email' => 'admin@bienetre.be',
            'password' => Hash::make('tatiadmin26'),
            'role' => 'ADMIN',
            'email_verified_at' => now(),
            //'adresse_id' => 1, // Assurez-vous que cet ID existe
        ]);
        

             Adresse::create([
                'id' => 1, // On force aussi l'ID de l'adresse
                'rue' => 'Rue de Administration',
                'numéro' => '1',
                'ville' => 'Bruxelles',
                'cp' => '1000',
                'pays' => 'Belgique'
            ]);

        User::factory(15)->create();
        Adresse::factory(50)->create();
        Categorie::factory(5)->create();
   

    }
}
