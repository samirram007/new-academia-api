<?php

namespace App\Http\Resources\AttendanceType;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class AttendanceTypeCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
