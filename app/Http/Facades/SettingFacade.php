<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\SettingServiceInterface;

class SettingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingServiceInterface::class;
    }
}
