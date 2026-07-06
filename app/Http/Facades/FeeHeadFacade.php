<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeHeadServiceInterface;

class FeeHeadFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeHeadServiceInterface::class;
    }
}
