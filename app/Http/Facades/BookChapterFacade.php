<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\BookChapterServiceInterface;

class BookChapterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BookChapterServiceInterface::class;
    }
}
