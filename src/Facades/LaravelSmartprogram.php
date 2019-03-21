<?php

namespace yangze\LaravelSmartprogram\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSmartprogram extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'smartprogram';
    }
}
