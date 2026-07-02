<?php

namespace App\Http\Resources\AcademicStandard;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class AcademicStandardResource extends SuccessResource
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
        ];
    }
}
