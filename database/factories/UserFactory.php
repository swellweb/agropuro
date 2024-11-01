<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt(env('DEFAULT_USER_PASSWORD', 'password')), // Usa variabile di ambiente per la password di default
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['user', 'farmer']),
        ];
    }
}
