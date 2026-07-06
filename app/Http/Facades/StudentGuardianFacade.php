<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\StudentGuardianServiceInterface;

class StudentGuardianFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StudentGuardianServiceInterface::class;
    }
}
