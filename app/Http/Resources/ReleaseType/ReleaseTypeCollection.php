<?php

namespace App\Http\Resources\ReleaseType;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class ReleaseTypeCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
