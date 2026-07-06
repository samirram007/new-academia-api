<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\DepartmentServiceInterface;

class DepartmentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DepartmentServiceInterface::class;
    }
}
