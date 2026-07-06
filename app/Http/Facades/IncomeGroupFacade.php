<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\IncomeGroupServiceInterface;

class IncomeGroupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IncomeGroupServiceInterface::class;
    }
}
