<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AddressServiceInterface;

class AddressFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AddressServiceInterface::class;
    }
}
