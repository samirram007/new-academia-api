<?php

namespace App\Http\Resources\RoomType;

use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class RoomTypeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
