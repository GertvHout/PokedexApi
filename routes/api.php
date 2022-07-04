<?php

use App\Http\Controllers\Api\V1\PokemonController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\API\V2\PokemonV2Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/pokemons', [PokemonController::class, 'index']);
Route::get('/v1/pokemons/{id}', [PokemonController::class, 'show']);
Route::get('/v1/search', [PokemonController::class, 'search']); 
Route::get('v1/import/{id}', [PokemonController::class, 'import']);

Route::get('v2/pokemons', [PokemonV2Controller::class, 'index']);


Route::apiResource('/v1/teams',TeamController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
