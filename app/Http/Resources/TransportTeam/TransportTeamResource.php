<?php

namespace App\Http\Resources\TransportTeam;

use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Transport\TransportResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class TransportTeamResource extends SuccessResource
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
            'transport_id' => $this->transport_id,
            'user_id' => $this->user_id,
            'team_role_id' => $this->team_role_id,
            "transport"=>new TransportResource($this->whenLoaded('transport')),
            "user"=>new UserResource($this->whenLoaded('user')),

        ];
    }
}
