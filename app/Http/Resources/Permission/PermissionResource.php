<?php

namespace App\Http\Resources\Permission;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class PermissionResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
