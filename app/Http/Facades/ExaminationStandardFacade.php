<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExaminationStandardServiceInterface;

class ExaminationStandardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExaminationStandardServiceInterface::class;
    }
}
