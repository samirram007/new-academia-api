<?php

namespace App\Http\Resources\GuardianType;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class GuardianTypeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
