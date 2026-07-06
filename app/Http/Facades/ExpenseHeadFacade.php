<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExpenseHeadServiceInterface;

class ExpenseHeadFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExpenseHeadServiceInterface::class;
    }
}
