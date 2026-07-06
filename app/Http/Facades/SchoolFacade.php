<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SchoolServiceInterface;

class SchoolFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SchoolServiceInterface::class;
    }
}
