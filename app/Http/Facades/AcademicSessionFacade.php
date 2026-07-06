<?php

namespace App\Http\Facades;

use App\Http\Contracts\AcademicSessionServiceInterface;
use Illuminate\Support\Facades\Facade;

class AcademicSessionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AcademicSessionServiceInterface::class;
    }
}
