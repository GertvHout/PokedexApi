<?php

use App\Http\Resources\PokemonDetailsResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use App\Models\PokemonDetails;
use Illuminate\Support\Facades\File;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
        $id = 1;
        $pokemon = PokemonDetails::find(1);
        return view('Index', ["pokemon" => $pokemon]);
});
