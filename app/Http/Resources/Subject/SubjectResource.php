<?php

namespace App\Http\Resources\Subject;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\SubjectGroup\SubjectGroupResource;
use App\Http\Resources\AcademicStandard\AcademicStandardResource;


class SubjectResource extends SuccessResource
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
            'code' => $this->code,
            'description' => $this->description,
            'subject_type' => $this->subject_type,
            'subject_group_id' => $this->subject_group_id,
            'academic_standard_id' => $this->academic_standard_id,
            'logo_image_id' => $this->logo_image_id,
            'subject_group'=> $this->whenNotNull(new SubjectGroupResource($this->whenLoaded('subject_group'))),
            'academic_standard'=> $this->whenNotNull(new AcademicStandardResource($this->whenLoaded('academic_standard'))),
            'logo_image'=> $this->whenNotNull(new DocumentResource($this->whenLoaded('logo_image'))),
        ];
    }
}
