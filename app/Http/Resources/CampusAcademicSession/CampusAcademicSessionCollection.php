<?php

namespace App\Http\Resources\CampusAcademicSession;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class CampusAcademicSessionCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
