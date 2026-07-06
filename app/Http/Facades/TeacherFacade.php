<?php

namespace App\Http\Facades;

use App\Http\Contracts\TeacherServiceInterface;
use Illuminate\Support\Facades\Facade;

class TeacherFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TeacherServiceInterface::class;
    }
}
