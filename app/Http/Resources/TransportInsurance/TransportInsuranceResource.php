<?php

namespace App\Http\Resources\TransportInsurance;

use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Transport\TransportResource;
use Illuminate\Http\Request;

class TransportInsuranceResource extends SuccessResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'transport_id' => $this->transport_id,
            'document_id' => $this->document_id,
            "transport"=>new TransportResource($this->whenLoaded('transport')),
            "document"=>new DocumentResource($this->whenLoaded('document')),

        ];
    }
}
