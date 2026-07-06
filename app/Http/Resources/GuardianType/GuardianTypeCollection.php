<?php

namespace App\Http\Resources\GuardianType;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class GuardianTypeCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
