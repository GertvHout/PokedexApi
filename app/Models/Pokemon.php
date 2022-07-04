<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        "id",
        "sprites",
        "types"

    ];

    protected $casts = [
        'types' => 'array',
        'sprites' => 'array'
    ];

    public $incrementing = false;
}
