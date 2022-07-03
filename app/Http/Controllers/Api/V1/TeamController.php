<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Error;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource_;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = TeamResource::collection(Team::all());
        return $collection;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::create([
            'name' => $request->name,
            'pokemons' => $request->pokemons
        ]);

        return $team;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = new TeamResource(Team::find($id));

        if ($team == null) {
            return "team not found";
        }

        return $team;
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
        $team = new TeamResource(Team::find($id));

        if ($team == null){
            return 'team not found';
        }

        if (count($request->pokemons) > 6) {
            return 'unable to add more then 6 pokemons to a team';
        }

        $team->update([
            'pokemons' => $request->pokemons
        ]);
        return $team;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = new TeamResource(Team::find($id));

        if ($team == null) {
            return 'team not found'; 
        }

        Team::destroy($id);

        return 'team ' . $id . ' deleted';
    }
}
