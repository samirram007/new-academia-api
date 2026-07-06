<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SectionServiceInterface;

class SectionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SectionServiceInterface::class;
    }
}
