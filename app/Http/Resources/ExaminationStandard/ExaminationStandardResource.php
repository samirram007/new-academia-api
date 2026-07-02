<?php

namespace App\Http\Resources\ExaminationStandard;

use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Resources\Examination\ExaminationResource;
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
            'academic_standard'=> new AcademicStandardResource($this->whenLoaded('academic_standard')),
            'examination'=> new ExaminationResource($this->whenLoaded('examination'))
        ];
    }
}
