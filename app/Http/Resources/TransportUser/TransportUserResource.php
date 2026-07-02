<?php

namespace App\Http\Resources\TransportUser;

use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\JourneyType\JourneyTypeResource;
use App\Http\Resources\StudentSession\StudentSessionResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Transport\TransportResource;
use App\Http\Resources\User\UserResource;
use App\Models\TransportPickupDrop;
use Illuminate\Http\Request;

class TransportUserResource extends SuccessResource
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
            'student_session_id' => $this->student_session_id,
            'transport_id' => $this->transport_id,
            'team_slot_id' => $this->team_slot_id,
            'pickup_point_id' => $this->pickup_point_id,
            'drop_point_id' => $this->drop_point_id,
            'pickup_time' => $this->pickup_time,
            'pickup_time' => $this->pickup_time,
            'join_date' => $this->join_date,
            'dissociate_date' => $this->dissociate_date,
            'is_active' => $this->is_active,
            'journey_type_id' => $this->journey_type_id,

            'is_free' => $this->is_free,
            'monthly_charge' => $this->monthly_charge,
            'is_idcard_printable' => $this->is_idcard_printable,
            'idcard_print_count' => $this->idcard_print_count,
            'is_release_idcard_printable' => $this->is_release_idcard_printable,
            'release_idcard_print_count' => $this->release_idcard_print_count,
            "user"=>new UserResource($this->whenLoaded('user')),
            "student_session"=>new StudentSessionResource($this->whenLoaded('student_session')),
            "transport"=>new TransportResource($this->whenLoaded('transport')),
            // "pickup_slot"=>new TransportSlotResource($this->whenLoaded('pickup_slot')),
            // "drop_slot"=>new TransportSlotResource($this->whenLoaded('drop_slot')),
            // "pickup_point"=>new TransportPickupDropPointResource($this->whenLoaded('pickup_point')),
            // "drop_point"=>new TransportPickupDropPointResource($this->whenLoaded('drop_point')),
            "journey_type"=>new JourneyTypeResource($this->whenLoaded('journey_type')),

        ];
    }
}
