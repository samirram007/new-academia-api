<?php

namespace App\Http\Resources\AttendanceMode;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class AttendanceModeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
