<?php

namespace App\Http\Resources\ExaminationSchedule;

use App\Http\Resources\ExaminationStandard\ExaminationStandardResource;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class ExaminationScheduleResource extends SuccessResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'examination_standard'=> new ExaminationStandardResource($this->whenLoaded('examination_standard')),
            'subject'=> new SubjectResource($this->whenLoaded('subject')),
            'examination_date' => $this->examination_date,
            'examination_time' => $this->examination_time,
            'teacher'=> new UserResource($this->whenLoaded('teacher'))
        ];
    }
}
