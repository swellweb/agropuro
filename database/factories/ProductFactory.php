<?php

namespace Database\Factories;
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
            'immagine' => "default/". \Str::slug($tipo) . ".webp",
            'video' => null,
            'galleria' => null,
            'tag' => json_encode($this->faker->words(3)),
            'stagionalita' => $this->faker->randomElement(['Primavera', 'Estate', 'Autunno', 'Inverno', 'Tutto l’anno']),
            'certificazioni' => $this->faker->randomElement(['Bio', 'DOP', 'IGP', null]),
        ];
    }
}
