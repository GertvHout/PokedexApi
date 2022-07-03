<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PokemonDetailsResource;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use App\Models\PokemonDetails;
use Illuminate\Http\Request;

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
        $collection = new PokemonDetailsResource(PokemonDetails::find($id));
        
        
        return $collection;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
