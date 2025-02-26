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
       // Crea i ruoli
       $this->call(RoleSeeder::class);

       // Crea 10 utenti generici (con ruoli 'user' o 'administrator')
       \App\Models\User::factory()->count(10)->create();

       // Crea 10 agricoltori (con ruolo 'farmer' e prodotti)
       \App\Models\Farmer::factory()->count(10)->create();
    }
}
