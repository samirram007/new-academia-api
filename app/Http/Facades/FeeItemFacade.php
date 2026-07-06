<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeItemServiceInterface;

class FeeItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeItemServiceInterface::class;
    }
}
