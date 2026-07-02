<?php

namespace App\Http\Resources\Transport;

use App\Http\Resources\SuccessResource;
use App\Http\Resources\TransportInsurance\TransportInsuranceResource;
use App\Http\Resources\TransportType\TransportTypeResource;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportResource extends SuccessResource
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
            'registration_no' => $this->registration_no,
            'registration_date' => $this->registration_date,
            'registration_valid_date' => $this->registration_valid_date,
            'chasis_no' => $this->chasis_no,
            'engine_no' => $this->engine_no,
            'capacity' => $this->capacity,
            'transport_insurance_id' => $this->transport_insurance_id,
            'transport_type_id' => $this->transport_type_id,
            "transport_type"=>new TransportTypeResource($this->whenLoaded('transport_type')),
            "transport_insurance"=>new TransportInsuranceResource($this->whenLoaded('transport_insurance')),

        ];
    }
}
