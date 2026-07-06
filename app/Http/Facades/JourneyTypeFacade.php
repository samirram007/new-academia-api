<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\JourneyTypeServiceInterface;

class JourneyTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return JourneyTypeServiceInterface::class;
    }
}
