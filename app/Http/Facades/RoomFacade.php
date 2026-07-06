<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\RoomServiceInterface;

class RoomFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RoomServiceInterface::class;
    }
}
