<?php

namespace Database\Factories;

use App\Helpers\PokemonHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'pokemons' => PokemonHelper::generatePokemonsArray(random_int(1,6))
        ];
    }
}
