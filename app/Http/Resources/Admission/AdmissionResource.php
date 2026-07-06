<?php

namespace App\Http\Resources\Admission;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class AdmissionResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
