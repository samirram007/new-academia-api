<?php

namespace App\Http\Resources\Promotion;

use App\Http\Resources\SuccessResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Http\Resources\Campus\CampusResource;
use Illuminate\Http\Request;

class PromotionResource extends SuccessResource
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
            'promotion_no' => $this->promotion_no,
            'promotion_date' => $this->promotion_date,
            'student_id' => $this->student_id,
            'old_student_session_id' => $this->old_student_session_id,
            'old_campus_id' => $this->old_campus_id,
            'old_academic_session_id' => $this->old_academic_session_id,
            'old_academic_class_id' => $this->old_academic_class_id,
            'old_academic_standard_id' => $this->old_academic_standard_id,
            'new_student_session_id' => $this->new_student_session_id,
            'new_campus_id' => $this->new_campus_id,
            'new_academic_session_id' => $this->new_academic_session_id,
            'new_academic_class_id' => $this->new_academic_class_id,
            'new_academic_standard_id' => $this->new_academic_standard_id,
            'is_active' => $this->is_active,
            'is_deleted' => $this->is_deleted,
            'student' => new StudentResource($this->whenLoaded('student')),
            'old_academic_session' => new AcademicSessionResource($this->whenLoaded('oldAcademicSession')),
            'new_academic_session' => new AcademicSessionResource($this->whenLoaded('newAcademicSession')),
            'old_academic_class' => new AcademicClassResource($this->whenLoaded('oldAcademicClass')),
            'new_academic_class' => new AcademicClassResource($this->whenLoaded('newAcademicClass')),
            'old_campus' => new CampusResource($this->whenLoaded('oldCampus')),
            'new_campus' => new CampusResource($this->whenLoaded('newCampus')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

