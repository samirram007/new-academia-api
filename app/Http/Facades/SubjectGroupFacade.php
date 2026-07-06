<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SubjectGroupServiceInterface;

class SubjectGroupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SubjectGroupServiceInterface::class;
    }
}
