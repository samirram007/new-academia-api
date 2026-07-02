<?php

namespace App\Http\Resources\State;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'state_code' => $this->state_code,
            'country_id' => $this->country_id,
        ];
    }
}
