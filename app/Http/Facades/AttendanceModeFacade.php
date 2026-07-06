<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AttendanceModeServiceInterface;

class AttendanceModeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AttendanceModeServiceInterface::class;
    }
}
