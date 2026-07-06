<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExaminationServiceInterface;

class ExaminationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExaminationServiceInterface::class;
    }
}
