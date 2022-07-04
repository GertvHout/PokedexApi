<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pokemon;
use App\Models\PokemonDetails;
use Illuminate\Support\Facades\File;
use App\Helpers\PokemonHelper;
use App\Models\Team;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Pokemon::truncate();

        $json = File::get('database/data/pokemons.json');
        $pokemons = json_decode($json);

        foreach ($pokemons as $pokemon){

            Pokemon::create([
                "id" => $pokemon->id,
                "name" => $pokemon->name,
                "sprites" => PokemonHelper::GetPokemonSprites($pokemon, ["front_default"]),
                "types" => PokemonHelper::GetPokemonTypes($pokemon)
            ]);
            
            //populate pokemonDetails table
            PokemonDetails::create([
                "id" => $pokemon->id,
                "name" => $pokemon->name,
                "sprites" => PokemonHelper::GetPokemonSprites($pokemon, [
                    "front_default",
                    "front_female",
                    "front_shiny",
                    "front_shiny_female",
                    "back_default",
                    "back_female",
                    "back_shiny",
                    "back_shiny_female",
                
                ]),
                "types" => PokemonHelper::GetPokemonTypes($pokemon),
                "height" => $pokemon->height,
                "weight" => $pokemon->weight,
                "moves" => PokemonHelper::GetPokemonMoves($pokemon),
                "order" => $pokemon->order,
                "species" => $pokemon->species->name,
                "stats" => PokemonHelper::GetPokemonStats($pokemon),
                "abilities" => PokemonHelper::GetPokemonAbilities($pokemon),
                "form" => $pokemon->forms[0]->name,

            ]); 

            
        }

        Team::factory()->count(10)->create();
    }
}
