<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeReceiptServiceInterface;

class FeeReceiptFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeReceiptServiceInterface::class;
    }
}
