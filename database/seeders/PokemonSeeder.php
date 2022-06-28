<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pokemon;
use Illuminate\Support\Facades\File;

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

        foreach ($pokemons as $key => $value){
            Pokemon::create([
                "name" => $value->name
            ]);
        }
    }
}
