<?php

namespace App\Http\Resources\AcademicClass;

use App\Http\Resources\AcademicStandard\AcademicStandardResource;
use App\Http\Resources\Campus\CampusResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class AcademicClassResource extends SuccessResource
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
            'campus_id' => $this->campus_id,
            'academic_standard_id' => $this->academic_standard_id,
            // 'section_id' => $this->section_id,
            'campus' => new CampusResource($this->whenLoaded('campus')),
            'academic_standard' => new AcademicStandardResource($this->whenLoaded('academic_standard')),
            // 'section' => new SectionResource($this->whenLoaded('section')),
            'capacity' => $this->capacity,

        ];
    }
}
