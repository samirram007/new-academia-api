<?php

namespace App\Http\Resources\FeeReceipt;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessCollection;

class FeeReceiptCollection extends SuccessCollection
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

