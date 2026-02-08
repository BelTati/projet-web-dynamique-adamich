<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Adresses;
use App\Models\Categories;
use App\Models\Utilisateurs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        Utilisateurs::factory(15)->create();
        Adresses::factory(50)->create();
        Categories::factory(6)->create();
    
    }
}
