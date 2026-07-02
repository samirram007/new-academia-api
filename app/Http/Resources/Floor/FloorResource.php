<?php

namespace App\Http\Resources\Floor;

use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Campus\CampusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FloorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'building_id' => $this->building_id,
            'campus_id' => $this->building->campus_id,
            'capacity' => $this->capacity,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'campus' => new CampusResource($this->whenLoaded('campus')),
        ];

    }
}
