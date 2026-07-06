<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\ExaminationScheduleServiceInterface;

class ExaminationScheduleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExaminationScheduleServiceInterface::class;
    }
}
