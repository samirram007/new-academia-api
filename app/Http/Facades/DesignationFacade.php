<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\DesignationServiceInterface;

class DesignationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DesignationServiceInterface::class;
    }
}
