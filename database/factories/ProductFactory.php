<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition()
    {
        $tipo = $this->faker->randomElement([
            'Frutta', 'Verdura', 'Lattiero-Caseari', 'Cereali', 'Legumi',
            'Prodotti Trasformati','Miele e Derivati', 'Bevande', 'Vino'
        ]);

        return [
            'farmer_id' => \App\Models\Farmer::factory(),
            'nome' => $this->faker->word . ' ' . $tipo,
            'descrizione' => $this->faker->sentence,
            'tipo' => $tipo,
            'prezzo' => $this->faker->randomFloat(2, 1, 100),
            'quantita_disponibile' => $this->faker->numberBetween(1, 100),
            'unita_misura' => $this->faker->randomElement(['kg', 'litri', 'pezzi']),
           'immagine' => "default/" . \Str::slug($tipo) . ".webp", // Immagine default in webp
            'video' => null,
            'galleria' => null,
            'stagionalita' => $this->faker->randomElement(['Primavera', 'Estate', 'Autunno', 'Inverno', 'Tutto l’anno']),
            'certificazioni' => $this->faker->randomElement(['Bio', 'DOP', 'IGP', null]),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Aggiungi fino a 5 tag casuali dalla tabella tags
            $tags = Tag::factory()->count(5)->create()->pluck('id')->random(rand(1, 5))->all();
            $product->tags()->attach($tags);
        });
    }
}
