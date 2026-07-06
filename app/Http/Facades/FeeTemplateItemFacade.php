<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeTemplateItemServiceInterface;

class FeeTemplateItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeTemplateItemServiceInterface::class;
    }
}
