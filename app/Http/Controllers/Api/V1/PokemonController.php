<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\PokemonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PokemonDetailsResource;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use App\Models\PokemonDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isNull;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortQuery = $request->get('sort');
        $allowedSortParams = ['name','id'];
        $allowedSortValues = ['asc','desc'];

        $sort = explode('-', $sortQuery);

        if (in_array($sort[0], $allowedSortParams) && 
            in_array($sort[1], $allowedSortValues)) 
        {
            $collection = PokemonResource::collection(Pokemon::orderBy($sort[0],$sort[1])->get());
        }
        else
        {
            $collection = PokemonResource::collection(Pokemon::all());
        }
        
        return $collection;
    }

    /**
     * Display the pokemon with the type or name from the search parameter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query =  $request->get('query');
        $limit = $request->get('limit');
        
        if ($query == null) {
            return "no search query given";
        }

        $pokemons = PokemonResource::collection(Pokemon::whereJsonContains('types',[['type' => ['name' => $query]]])->orWhere('name', '=', $query)->limit($limit)->get());

        return $pokemons;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $pokemon = new PokemonDetailsResource(PokemonDetails::findorfail($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'pokemon not found'
            ], 404);
        }

        return $pokemon;
    }

    public function import($id)
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/'.$id);

        if ($response->successful()) {

            if (Pokemon::where('id','=',$id)->orWhere('name','=',$id)->get()->count() > 0) {
                return "pokemon already exists";
            }
            $pokemon = json_decode($response->body());

            
            Pokemon::create([
                "id" => $pokemon->id,
                "name" => $pokemon->name,
                "sprites" => PokemonHelper::GetPokemonSprites($pokemon, ["front_default"]),
                "types" => PokemonHelper::GetPokemonTypes($pokemon)
            ]);
            
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

            return "success";
        }

        return 'could not retrieve pokemon from external api';
    }
}
