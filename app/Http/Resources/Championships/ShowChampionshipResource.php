<?php

namespace App\Http\Resources\Championships;

use App\Http\Resources\Teams\ShowTeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowChampionshipResource extends JsonResource
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
            'logo' => $this->logo,
            'teams' => ShowTeamResource::collection($this->whenLoaded('teams')),
        ];
    }
}
