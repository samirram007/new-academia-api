<?php

namespace App\Http\Resources\TransportSlot;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class TransportSlotResource extends SuccessResource
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
