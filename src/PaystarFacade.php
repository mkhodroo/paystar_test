<?php

namespace Mkhodroo\PaystarTest;

use Illuminate\Support\Facades\Facade;

class PaystarFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paystar';
    }
}