<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "sprites",
        "types",
        "height",
        "weight",
        "moves",
        "order",
        "species",
        "stats",
        "abilities",
        "form",
    ];

    protected $casts = [
        'types' => 'array',
        'sprites' => 'array',
        'moves' => 'array',
        'stats' => 'array',
        'abilities' => 'array'

    ];

    public $incrementing = false;
}
