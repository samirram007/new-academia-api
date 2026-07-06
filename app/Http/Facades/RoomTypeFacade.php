<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\RoomTypeServiceInterface;

class RoomTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RoomTypeServiceInterface::class;
    }
}
