<?php

namespace App\Http\Resources\ReleaseType;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class ReleaseTypeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
