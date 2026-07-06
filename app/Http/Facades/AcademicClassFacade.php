<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AcademicClassServiceInterface;

class AcademicClassFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AcademicClassServiceInterface::class;
    }
}
