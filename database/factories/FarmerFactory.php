<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerFactory extends Factory
{
    protected $model = Farmer::class;

    public function definition()
    {
        do {
            $alias = Str::upper(Str::random(6)); // Genera un alias di 6 caratteri alfanumerici
        } while (Farmer::where('alias', $alias)->exists());

        return [
            'user_id' => User::factory()->create(['role' => 'farmer'])->id,
            'alias' => $alias,
            'farm_name' => $this->faker->company,
            'latitude' => $this->faker->latitude(41, 45),
            'longitude' => $this->faker->longitude(9, 15),
            'product' => $this->faker->randomElement(['Verdure', 'Frutta', 'Latticini']),
        ];
    }
}
