<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\StateServiceInterface;

class StateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StateServiceInterface::class;
    }
}
