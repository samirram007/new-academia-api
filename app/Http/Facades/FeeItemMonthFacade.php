<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeItemMonthServiceInterface;

class FeeItemMonthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeItemMonthServiceInterface::class;
    }
}
