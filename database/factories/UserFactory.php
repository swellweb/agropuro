<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        static $firstUserCreated = false;

        if (!$firstUserCreated) {
            $firstUserCreated = true;
            return [
                'name' => 'Marco Caciotti',
                'email' => 'mcaciotti@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Prova123$'), // Hash della password
                'remember_token' => Str::random(10),
                'subscription' => 'farm'
            ];
        }
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'subscription' => $this->faker->randomElement(['roots', 'supply', 'farm']),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\User $user) {
            // Assegna un ruolo casuale se non specificato
            $roles = ['user', 'administrator']; // Escludi 'farmer', gestito da FarmerFactory
            $user->roles()->attach(\App\Models\Role::where('name', $this->faker->randomElement($roles))->first());
        });
    }
}
