<?php

namespace App\Helpers;

class PokemonHelper
{
    public static function GetPokemonTypes($pokemon){
        //populate pokemons table
        $typesArray = $pokemon->types;
        $typesArrayNew = [];
    
        //remove url field from type
        foreach($typesArray as $typeArray){
            $typeArray = json_decode(json_encode($typeArray), true);
            $type = $typeArray['type'];
            unset($type['url']);
            $typeArray['type'] = $type ;
            array_push($typesArrayNew, $typeArray);
        }
    
        return $typesArrayNew;
    }

    public static function GetPokemonSprites($pokemon, $keys){

        $spritesArray = json_decode(json_encode($pokemon->sprites), true);
        $spritesArrayNew = [];

        foreach ($keys as $key) {
            $spritesArrayNew[$key] = $spritesArray[$key];
        }

        return (object) $spritesArrayNew;

    }

    public static function GetPokemonMoves($pokemon){

        $moves = [];

        foreach ($pokemon->moves as $move) {

            $moveArray = json_decode(json_encode($move), true);
            $versionGroupDetailsArray = [];

            //refactor version_group_details 
            foreach ($moveArray["version_group_details"] as $versionGroupDetail) {
                array_push($versionGroupDetailsArray,(object) [
                    "level_learned_at" => $versionGroupDetail["level_learned_at"],
                    "move_learn_method" =>$versionGroupDetail["move_learn_method"]["name"],
                    "version_group" =>$versionGroupDetail["version_group"]["name"]
                ]);
            }

            array_push($moves, (object) [
                "move" => $moveArray["move"]["name"],
                "version_group_details" => $versionGroupDetailsArray
            ]);
        }
        
        return $moves;
    }

    public static function GetPokemonStats($pokemon){

        $statsArray = [];

        foreach ($pokemon->stats as $stat) {
            array_push($statsArray, (object) [
                "stat" => $stat->stat->name,
                "base_stat" => $stat->base_stat,
                "effort" => $stat->effort
            ]);
        }

        return $statsArray;
    }

    static function GetPokemonAbilities($pokemon){

        $abilitiesArray = [];

        foreach ($pokemon->abilities as $ability) {
            array_push($abilitiesArray, (object) [
                "ability" => $ability->ability->name,
                "is_hidden" => $ability->is_hidden,
                "slot" => $ability->slot
            ]);
        }

        return $abilitiesArray;
    }
}
