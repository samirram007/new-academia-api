<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExpenseItemServiceInterface;

class ExpenseItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExpenseItemServiceInterface::class;
    }
}
