<?php

namespace App\Http\Resources\ExaminationSchedule;

use App\Http\Resources\ExaminationStandard\ExaminationStandardResource;
use App\Http\Resources\Room\RoomResource;
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
            'examination_standard_id' => $this->examination_standard_id,
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->teacher_id,
            'exam_date' => $this->exam_date ?? $this->examination_date,
            'start_time' => $this->start_time ?? $this->examination_time,
            'end_time' => $this->end_time,
            'room_id' => $this->room_id,
            'room'=> new RoomResource($this->whenLoaded('room')),
            'examination_standard'=> new ExaminationStandardResource($this->whenLoaded('examination_standard')),
            'subject'=> new SubjectResource($this->whenLoaded('subject')),
            'teacher'=> new UserResource($this->whenLoaded('teacher')),
        ];
    }
}
