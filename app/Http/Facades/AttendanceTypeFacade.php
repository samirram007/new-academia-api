<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AttendanceTypeServiceInterface;

class AttendanceTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AttendanceTypeServiceInterface::class;
    }
}
