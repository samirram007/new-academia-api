<?php

namespace App\Http\Resources\JourneyType;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class JourneyTypeResource extends SuccessResource
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
        ];
    }
}
