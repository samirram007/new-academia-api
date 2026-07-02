<?php

namespace App\Http\Resources\ExaminationResult;

use App\Http\Resources\ExaminationSchedule\ExaminationScheduleResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class ExaminationResultResource extends SuccessResource
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
            'examination_scheduled' => new ExaminationScheduleResource($this->whenLoaded('examination_scheduled')),
            'marks'=> $this->marks,
            'student' => new UserResource($this->whenLoaded('student'))
        ];
    }
}
