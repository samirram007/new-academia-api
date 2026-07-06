<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class RoleResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
