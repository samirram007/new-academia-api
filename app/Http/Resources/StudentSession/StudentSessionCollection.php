<?php

namespace App\Http\Resources\StudentSession;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class StudentSessionCollection extends SuccessCollection
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
