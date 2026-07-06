<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\BookServiceInterface;

class BookFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BookServiceInterface::class;
    }
}
