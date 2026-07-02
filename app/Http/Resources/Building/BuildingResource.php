<?php

namespace App\Http\Resources\Building;

use Illuminate\Http\Request;


use App\Http\Resources\SuccessResource;
use App\Http\Resources\Campus\CampusResource;


class BuildingResource extends SuccessResource
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
            'campus_id' => $this->campus_id,
            'capacity' => $this->capacity,
            'campus' => new CampusResource($this->whenLoaded('campus')),
        ];

    }
}
