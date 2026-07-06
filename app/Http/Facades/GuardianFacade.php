<?php

namespace App\Http\Facades;

use App\Http\Contracts\GuardianServiceInterface;
use Illuminate\Support\Facades\Facade;

class GuardianFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GuardianServiceInterface::class;
    }
}
