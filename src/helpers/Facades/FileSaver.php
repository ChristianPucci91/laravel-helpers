<?php

namespace Pucci\LaravelHelpers\Facades;

use Illuminate\Support\Facades\Facade;

class FileSaver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filesaver';
    }
}
