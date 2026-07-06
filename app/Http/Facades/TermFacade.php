<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\TermServiceInterface;

class TermFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TermServiceInterface::class;
    }
}
