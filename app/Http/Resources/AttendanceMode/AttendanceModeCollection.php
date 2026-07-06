<?php

namespace App\Http\Resources\AttendanceMode;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class AttendanceModeCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
