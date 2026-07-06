<?php

namespace App\Http\Facades;

use App\Http\Contracts\AcademicStandardServiceInterface;
use Illuminate\Support\Facades\Facade;

class AcademicStandardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  AcademicStandardServiceInterface::class;
    }
}
