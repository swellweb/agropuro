<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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
                'role' => 'admin', // Ruolo admin
            ];
        }

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make(env('DEFAULT_USER_PASSWORD', 'password')), // Usa variabile di ambiente
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['user', 'farmer']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
