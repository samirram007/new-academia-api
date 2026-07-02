<?php

namespace App\Http\Resources\FeeReceipt;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
