<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Floor\FloorResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\Building\BuildingResource;

class RoomResource extends SuccessResource
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
            'floor_id' => $this->floor_id,
            'building_id' => $this->floor->building_id,
            'campus_id' => $this->floor->building->campus_id,
            'capacity' => $this->capacity,
            'floor' => new FloorResource($this->whenLoaded('floor')),
            'building' => new BuildingResource($this->whenLoaded('building')),
            'campus' => new CampusResource($this->whenLoaded('campus')),
            'room_type' => $this->room_type,
        ];
    }
}

