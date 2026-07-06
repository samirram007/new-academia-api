<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Contracts\FeeTemplateServiceInterface;

class FeeTemplateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeeTemplateServiceInterface::class;
    }
}
