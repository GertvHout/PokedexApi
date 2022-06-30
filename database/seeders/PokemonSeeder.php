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

        foreach ($pokemons as $value){
            
            
            $typesArray = $value->types;
            $typesArrayNew = [];

            //remove url field from type
            foreach($typesArray as $typeArray){
                $typeArray = json_decode(json_encode($typeArray), true);
                $type = $typeArray['type'];
                unset($type['url']);
                $typeArray['type'] = $type ;
                array_push($typesArrayNew, $typeArray);
            }

            //retrieve only the "front_default" sprite
            $spritesArray = (object) ["front_default" => json_decode(json_encode($value->sprites), true)['front_default']];

            Pokemon::create([
                "name" => $value->name,
                "sprites" => $spritesArray,
                "types" => $typesArrayNew
            ]);
        }
    }
}
