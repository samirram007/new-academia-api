<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeServiceInterface;

class FeeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeServiceInterface::class;
    }
}
