<?php

namespace App\Http\Facades;

use App\Http\Contracts\StudentIdCardServiceInterface;
use Illuminate\Support\Facades\Facade;

class StudentIdCardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StudentIdCardServiceInterface::class;
    }
}
