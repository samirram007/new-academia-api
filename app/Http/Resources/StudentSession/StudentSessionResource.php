<?php

namespace App\Http\Resources\StudentSession;

use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\FeeItemMonth\FeeItemMonthCollection;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class StudentSessionResource extends SuccessResource
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
            'student_id' => $this->student_id,
            'academic_session_id' => $this->academic_session_id,
            'academic_class_id' => $this->academic_class_id,
            'campus_id' => $this->campus_id,
            'academic_standard_id' => $this->academic_standard_id,
            'section_id' => $this->section_id,
            'roll_no' => $this->roll_no,
            'status' => $this->status,
            'is_promoted' => $this->is_promoted,
            'next_student_session_id' => $this->next_student_session_id,
            'previous_student_session_id' => $this->previous_student_session_id,
            'is_idcard_printable' => $this->is_idcard_printable,
            'idcard_print_count' => $this->idcard_print_count,

            'student'=> $this->whenNotNull(new StudentResource($this->whenLoaded('student'))),
            'academic_session'=> $this->whenNotNull(new AcademicSessionResource($this->whenLoaded('academic_session'))),
            'academic_class'=> $this->whenNotNull(new AcademicClassResource($this->whenLoaded('academic_class'))),
            'academic_standard'=> $this->whenNotNull(new AcademicStandardResource($this->whenLoaded('academic_standard'))),
            'section'=> $this->whenNotNull(new SectionResource($this->whenLoaded('section'))),
            'campus'=> $this->whenNotNull(new CampusResource($this->whenLoaded('campus'))),
            'next_student_session'=>new StudentSessionResource($this->whenLoaded('next_student_session')),
            'previous_student_session'=>new StudentSessionResource($this->whenLoaded('previous_student_session')),
            "fee_item_months"=>new FeeItemMonthCollection($this->whenLoaded('fee_item_months')),
        ];
    }
}
