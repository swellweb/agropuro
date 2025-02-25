<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crea 10 utenti
        User::factory()->count(10)->create();

        // Crea 5 agricoltori
        Farmer::factory()->count(8)->create();
    }
}
