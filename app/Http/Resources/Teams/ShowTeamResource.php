<?php

namespace App\Http\Resources\Teams;

use App\Http\Resources\Championships\ShowChampionshipResource;
use App\Http\Resources\Players\ShowPlayerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'championship' => new ShowChampionshipResource($this->whenLoaded('championship')),
            'players' => ShowPlayerResource::collection($this->whenLoaded('players'))
        ];
    }
}
