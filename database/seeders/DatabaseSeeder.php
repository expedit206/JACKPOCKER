<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Produitseeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CompteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

   
        $this->call([
            Produitseeder::class,
            UserSeeder::class,
            ProduitUserseeder::class,
            Epargneseeder::class,
            // CompteSeeder::class,
        ]);
    }
}
