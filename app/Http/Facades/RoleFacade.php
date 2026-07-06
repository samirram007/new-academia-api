<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\RoleServiceInterface;

class RoleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RoleServiceInterface::class;
    }
}
