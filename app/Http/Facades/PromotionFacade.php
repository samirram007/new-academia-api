<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\PromotionServiceInterface;

class PromotionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PromotionServiceInterface::class;
    }
}
