<?php

namespace App\Http\Resources\Players;

use App\Http\Resources\Teams\ShowTeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPlayerResource extends JsonResource
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
            'surname' => $this->surname,
            'personal_number' => $this->personal_number,
            'team' => new ShowTeamResource($this->whenLoaded('team')),
        ];
    }
}
