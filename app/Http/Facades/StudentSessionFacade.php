<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\StudentSessionServiceInterface;

class StudentSessionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StudentSessionServiceInterface::class;
    }
}
