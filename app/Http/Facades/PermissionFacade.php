<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\PermissionServiceInterface;

class PermissionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PermissionServiceInterface::class;
    }
}
