<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeFeePaymentServiceInterface;

class FeeFeePaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeFeePaymentServiceInterface::class;
    }
}
