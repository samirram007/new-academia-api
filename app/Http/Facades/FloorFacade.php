<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FloorServiceInterface;

class FloorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FloorServiceInterface::class;
    }
}
