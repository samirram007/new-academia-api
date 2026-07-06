<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\PeriodServiceInterface;

class PeriodFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PeriodServiceInterface::class;
    }
}
