<?php

namespace App\Http\Resources\TransportPickupDrop;

use App\Http\Resources\JourneyType\JourneyTypeResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Transport\TransportResource;
use App\Http\Resources\TransportPickupDropPoint\TransportPickupDropPointResource;
use App\Http\Resources\TransportSlot\TransportSlotResource;
use App\Http\Resources\TransportTeam\TransportTeamResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class TransportPickupDropResource extends SuccessResource
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
            'user_id' => $this->user_id,
            'pickup_drop_points_id' => $this->pickup_drop_points_id,
            'pickup_drop_date' => $this->pickup_drop_date,
            'pickup_time' => $this->pickup_time,
            'drop_time' => $this->drop_time,
            'transport_id' => $this->transport_id,
            'journey_type_id' => $this->journey_type_id,
            'transport_slot_id' => $this->transport_slot_id,
            'transport_team_id' => $this->transport_team_id,
            'status' => $this->status,
            "user"=>new UserResource($this->whenLoaded('user')),
            "pickup_drop_point"=>new TransportPickupDropPointResource($this->whenLoaded('pickup_drop_point')),
            "transport"=>new TransportResource($this->whenLoaded('transport')),
            "transport_slot"=>new TransportSlotResource($this->whenLoaded('transport_slot')),
            "transport_team"=>new TransportTeamResource($this->whenLoaded('transport_team')),
            "journey_type"=>new JourneyTypeResource($this->whenLoaded('journey_type')),
        ];
    }
}
