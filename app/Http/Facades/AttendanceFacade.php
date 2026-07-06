<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AttendanceServiceInterface;

class AttendanceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AttendanceServiceInterface::class;
    }
}
