<?php

namespace App\Http\Resources\Promotion;


use App\Http\Resources\SuccessResource;

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

        $data=[
            'id' => $this->id,
            'student_id' => $this->student_id,
            'old_student_session_id' => $this->old_student_session_id,
            'old_campus_id'=>$this->old_campus_id,
            'old_academic_session_id'=>$this->old_academic_session_id,
            'old_academic_class_id'=>$this->old_academic_class_id,
            'old_academic_standard_id'=>$this->old_academic_standard_id,
            'new_student_session_id' => $this->new_student_session_id,
            'new_campus_id'=>$this->new_campus_id,
            'new_academic_session_id'=>$this->new_academic_session_id,
            'new_academic_class_id'=>$this->new_academic_class_id,
            'new_academic_standard_id'=>$this->new_academic_standard_id,
            'is_active'=>$this->is_active,
        ];


        return $data;
    }


}

