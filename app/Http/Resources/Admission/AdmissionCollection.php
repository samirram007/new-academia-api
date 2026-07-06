<?php

namespace App\Http\Resources\Admission;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class AdmissionCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
