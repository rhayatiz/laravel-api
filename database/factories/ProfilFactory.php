<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statut = $this->faker->randomElement([
            'en attente',
            'inactif',
            'actif',
        ]);


        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'statut' => $statut,
        ];
    }
}
