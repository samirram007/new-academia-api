<?php

namespace App\Http\Resources\IncomeGroup;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class IncomeGroupResource extends SuccessResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
