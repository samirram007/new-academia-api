<?php

namespace App\Http\Resources\Campus;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\EducationBoard\EducationBoardResource;
use App\Http\Resources\School\SchoolResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class CampusResource extends SuccessResource
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
            'code' => $this->whenNotNull($this->code),
            'school_id' => $this->whenNotNull($this->school_id),
            'education_board_id' => $this->whenNotNull($this->education_board_id),
            'address_id' => $this->whenNotNull($this->address_id),
            'school' => new SchoolResource($this->whenLoaded('school')),
            'education_board' => new EducationBoardResource($this->whenLoaded('education_board')),
            'address' => new AddressResource($this->whenLoaded('address')),
            'contact_no' => $this->whenNotNull($this->contact_no),
            'email' => $this->whenNotNull($this->email),
            'establishment_date' => $this->whenNotNull($this->establishment_date),
            'opening_time' => $this->whenNotNull($this->opening_time),
            'closing_time' => $this->whenNotNull($this->closing_time),
            'logo_image' => new DocumentResource($this->whenLoaded('logo_image')),
        ];
    }
}
