<?php

namespace App\Http\Resources\Period;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessCollection;

class PeriodCollection extends SuccessCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

