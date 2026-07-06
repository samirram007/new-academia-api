<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class RoleCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
