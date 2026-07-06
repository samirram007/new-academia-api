<?php

namespace App\Http\Resources\AttendanceType;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class AttendanceTypeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
