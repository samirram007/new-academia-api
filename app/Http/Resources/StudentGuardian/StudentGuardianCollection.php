<?php

namespace App\Http\Resources\StudentGuardian;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class StudentGuardianCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
