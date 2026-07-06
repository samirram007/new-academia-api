<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\BuildingServiceInterface;

class BuildingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BuildingServiceInterface::class;
    }
}
