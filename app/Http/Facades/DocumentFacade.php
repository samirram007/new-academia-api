<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\DocumentServiceInterface;

class DocumentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DocumentServiceInterface::class;
    }
}
