<?php

namespace App\Http\Resources\Fee;

use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\FeeItem\FeeItemCollection;
use App\Http\Resources\FeeTemplate\FeeTemplateResource;
use App\Http\Resources\StudentSession\StudentSessionCollection;
use App\Http\Resources\StudentSession\StudentSessionResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends SuccessResource
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
            'fee_no' => $this->fee_no,
            'fee_date' => $this->fee_date,
            'fee_template_id' => $this->fee_template_id,
            "campus_id" =>   $this->campus_id,
            'student_id' => $this->student_id,
            'student_session_id' => $this->student_session_id,
            'academic_session_id' => $this->academic_session_id,
            'academic_class_id' => $this->academic_class_id,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'balance_amount' => $this->balance_amount,
            'payment_mode' => $this->payment_mode,
            'paid_amount' => $this->paid_amount,
            'is_deleted'=>$this->is_deleted,
            'note'=>$this->note,
            'fee_template' => new FeeTemplateResource($this->whenLoaded('fee_template')),
            "academic_session" => new AcademicSessionResource($this->whenLoaded('academic_session')),
            "academic_class" => new AcademicClassResource($this->whenLoaded('academic_class')),
            "campus" => new CampusResource($this->whenLoaded('campus')),
            "student" => new UserResource($this->whenLoaded('student')),
            "fee_items" => new FeeItemCollection($this->whenLoaded('fee_items')),
            "student_session" => new StudentSessionResource($this->whenLoaded('student_session')),
        ];
    }
}

