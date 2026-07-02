<?php

namespace App\Http\Resources\Examination;

use App\Http\Resources\AcademicSession\AcademicSessionResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\ExaminationType\ExaminationTypeResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class ExaminationResource extends SuccessResource
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
            'name' => $this->name,
            'examination_type_id' => $this->examination_type_id,
            'academic_session_id' => $this->academic_session_id,
            'examination_start_date' => $this->examination_start_date,
            'examination_end_date' => $this->examination_end_date,
            'examination_type' => new ExaminationTypeResource($this->whenLoaded('examination_type')),
            'academic_session' => new AcademicSessionResource($this->whenLoaded('academic_session')),
        ];
    }
}