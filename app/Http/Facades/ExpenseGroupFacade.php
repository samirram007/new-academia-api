<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExpenseGroupServiceInterface;

class ExpenseGroupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExpenseGroupServiceInterface::class;
    }
}
