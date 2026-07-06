<?php

namespace App\Http\Resources\StudentGuardian;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class StudentGuardianResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'guardian_id' => $this->guardian_id,
        ];
    }
}
