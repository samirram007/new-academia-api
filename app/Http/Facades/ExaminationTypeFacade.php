<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExaminationTypeServiceInterface;

class ExaminationTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExaminationTypeServiceInterface::class;
    }
}
