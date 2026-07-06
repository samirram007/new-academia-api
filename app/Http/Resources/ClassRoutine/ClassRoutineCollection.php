<?php

namespace App\Http\Resources\ClassRoutine;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class ClassRoutineCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
