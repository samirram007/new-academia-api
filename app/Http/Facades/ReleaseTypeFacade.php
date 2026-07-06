<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ReleaseTypeServiceInterface;

class ReleaseTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReleaseTypeServiceInterface::class;
    }
}
