<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\CountryServiceInterface;

class CountryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CountryServiceInterface::class;
    }
}
