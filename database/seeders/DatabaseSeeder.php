<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Farmer;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crea 10 utenti
        User::factory()->count(10)->create();

        // Crea 5 agricoltori
        Farmer::factory()->count(8)->create();
    }
}
