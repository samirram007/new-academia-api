<?php

namespace App\Http\Resources\ClassRoutine;

use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Room\RoomResource;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class ClassRoutineResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'day_of_week' => $this->day_of_week,
            'academic_session_id' => $this->academic_session_id,
            'academic_class_id' => $this->academic_class_id,
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->teacher_id,
            'room_id' => $this->room_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'academic_session' => new AcademicSessionResource($this->whenLoaded('academic_session')),
            'academic_class' => new AcademicClassResource($this->whenLoaded('academic_class')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'teacher' => new UserResource($this->whenLoaded('teacher')),
            'room' => new RoomResource($this->whenLoaded('room')),
        ];
    }
}
