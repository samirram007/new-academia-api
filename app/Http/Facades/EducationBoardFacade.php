<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\EducationBoardServiceInterface;

class EducationBoardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return EducationBoardServiceInterface::class;
    }
}
