<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\BookModuleServiceInterface;

class BookModuleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BookModuleServiceInterface::class;
    }
}
