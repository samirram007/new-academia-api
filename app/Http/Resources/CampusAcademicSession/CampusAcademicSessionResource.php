<?php

namespace App\Http\Resources\CampusAcademicSession;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class CampusAcademicSessionResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
