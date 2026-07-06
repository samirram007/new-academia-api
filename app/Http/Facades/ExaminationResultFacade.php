<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExaminationResultServiceInterface;

class ExaminationResultFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExaminationResultServiceInterface::class;
    }
}
