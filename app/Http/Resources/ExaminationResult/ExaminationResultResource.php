<?php

namespace App\Http\Resources\ExaminationResult;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Resources\ExaminationSchedule\ExaminationScheduleResource;
use App\Http\Resources\Subject\SubjectResource;
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
            'examination_schedule_id' => $this->examination_schedule_id,
            'student_id' => $this->student_id,
            'marks_obtained' => $this->marks_obtained ?? $this->marks,
            'grade' => $this->grade,
            'remarks' => $this->remarks,
            'examination_schedule' => new ExaminationScheduleResource($this->whenLoaded('examination_schedule')),
            'student' => new UserResource($this->whenLoaded('student')),

            // Convenience fields for the frontend
            'academic_session' => $this->whenLoaded('examination_schedule', function () {
                return new AcademicSessionResource(
                    $this->examination_schedule?->examination_standard?->examination?->academic_session
                );
            }),
            'academic_standard' => $this->whenLoaded('examination_schedule', function () {
                return new AcademicStandardResource(
                    $this->examination_schedule?->examination_standard?->academic_standard
                );
            }),
            'subject' => $this->whenLoaded('examination_schedule', function () {
                return new SubjectResource(
                    $this->examination_schedule?->subject
                );
            }),
        ];
    }
}
