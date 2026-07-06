<?php

namespace App\Http\Facades;

use App\Http\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Facade;

class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserServiceInterface::class;
    }
}
