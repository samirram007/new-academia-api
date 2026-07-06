<?php

namespace App\Http\Resources\Permission;

use App\Http\Resources\SuccessCollection;
use Illuminate\Http\Request;

class PermissionCollection extends SuccessCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
