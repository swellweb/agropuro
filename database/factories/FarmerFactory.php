<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerFactory extends Factory
{
    protected $model = Farmer::class;

    public function definition()
    {
        do {
            $alias = Str::upper(Str::random(6));
        } while (Farmer::where('alias', $alias)->exists());

        return [
            'user_id' => User::factory()->create()->id,
            'alias' => $alias,
            'farm_name' => $this->faker->company,
            'latitude' => $this->faker->latitude(41, 45),
            'longitude' => $this->faker->longitude(9, 15),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Farmer $farmer) {
            $farmer->user->roles()->attach(\App\Models\Role::firstOrCreate(['name' => 'farmer']));
            $numProducts = $this->faker->numberBetween(1, 5);
            Product::factory()->count($numProducts)->create(['farmer_id' => $farmer->id]);
        });
    }
}
