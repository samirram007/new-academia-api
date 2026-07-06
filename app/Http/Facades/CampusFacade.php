<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\CampusServiceInterface;

class CampusFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CampusServiceInterface::class;
    }
}
