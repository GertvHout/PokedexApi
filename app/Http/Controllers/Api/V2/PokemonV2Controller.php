<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonV2Controller extends Controller
{
    public function index(Request $request){
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $page = $request->get('page');

        $sortQuery = $request->get('sort');
        $allowedSortParams = ['name','id'];
        $allowedSortValues = ['asc','desc'];

        $sort = explode('-', $sortQuery);

        $urlQuery = [];

        ($limit == null)? $limit = 20 : $urlQuery['limit'] = $limit;

        if ($offset != null && $offset > 0)
        {
            $page =  floor($offset / $limit) + 1;
        } 

        if (in_array($sort[0], $allowedSortParams) && 
            in_array($sort[1], $allowedSortValues)) 
        {
            $urlQuery['sort'] = $sortQuery;
            $collection = PokemonResource::collection(Pokemon::orderBy($sort[0],$sort[1])->simplePaginate($limit,['*'],'page', $page));
        }
        else
        {
            $collection = PokemonResource::collection(Pokemon::simplePaginate($limit,['*'],'page', $page));
        }
        
        return $collection->appends($urlQuery);
    }
}
