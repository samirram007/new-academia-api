<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\DocumentsFolderServiceInterface;

class DocumentsFolderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DocumentsFolderServiceInterface::class;
    }
}
