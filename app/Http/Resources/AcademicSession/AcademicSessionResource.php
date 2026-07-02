<?php

namespace App\Http\Resources\AcademicSession;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Campus\CampusResource;

class AcademicSessionResource extends SuccessResource
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
            'session' => $this->whenNotNull($this->session),
            'start_date' => $this->whenNotNull($this->start_date),
            'end_date' => $this->whenNotNull($this->end_date),
            'previous_academic_session_id' => $this->whenNotNull($this->previous_academic_session_id),
            'next_academic_session_id' => $this->whenNotNull($this->next_academic_session_id),
            "previous_academic_session"=>new AcademicSessionResource($this->whenLoaded('previous_academic_session')),
            "next_academic_session"=>new AcademicSessionResource($this->whenLoaded('next_academic_session')),
            'is_current' => $this->whenNotNull($this->is_current),
        ];
    }
}
