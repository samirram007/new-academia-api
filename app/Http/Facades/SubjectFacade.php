<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SubjectServiceInterface;

class SubjectFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SubjectServiceInterface::class;
    }
}
