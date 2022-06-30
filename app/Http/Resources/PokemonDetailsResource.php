<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PokemonDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sprites' => $this->sprites,
            'types' => $this->types,
            'height' => $this->height,
            'weight' => $this->weight,
            'moves' => $this->moves,
            'order' => $this->order,
            'stats' => $this->stats,
            'abilities' => $this->abilities,
            'species' => $this->species,
            'form' => $this->form
        ];    
    }
}
