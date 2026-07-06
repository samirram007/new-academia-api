<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\AdmissionServiceInterface;

class AdmissionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AdmissionServiceInterface::class;
    }
}
