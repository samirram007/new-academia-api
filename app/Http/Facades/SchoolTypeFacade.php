<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SchoolTypeServiceInterface;

class SchoolTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SchoolTypeServiceInterface::class;
    }
}
