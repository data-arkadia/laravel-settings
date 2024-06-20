<?php

namespace DataArkadia\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SettingManager';
    }
}
