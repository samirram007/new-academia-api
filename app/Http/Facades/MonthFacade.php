<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\MonthServiceInterface;

class MonthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MonthServiceInterface::class;
    }
}
