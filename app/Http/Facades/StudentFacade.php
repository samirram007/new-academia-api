<?php

namespace App\Http\Facades;

use App\Http\Contracts\StudentServiceInterface;
use Illuminate\Support\Facades\Facade;

class StudentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StudentServiceInterface::class;
    }
}
