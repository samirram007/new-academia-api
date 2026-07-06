<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ClassRoutineServiceInterface;

class ClassRoutineFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClassRoutineServiceInterface::class;
    }
}
