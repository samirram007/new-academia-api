<?php

namespace App\Http\Resources\ExaminationStandard;

use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Resources\Examination\ExaminationResource;
use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class ExaminationStandardResource extends SuccessResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'examination_id' => $this->examination_id,
            'academic_standard_id' => $this->academic_standard_id,
            'subject_id' => $this->subject_id,
            'passing_marks' => $this->passing_marks,
            'total_marks' => $this->total_marks,
            'academic_standard'=> new AcademicStandardResource($this->whenLoaded('academic_standard')),
            'examination'=> new ExaminationResource($this->whenLoaded('examination')),
            'subject'=> new SubjectResource($this->whenLoaded('subject')),
        ];
    }
}
