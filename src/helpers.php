<?php

use DataArkadia\LaravelSettings\Facades\SettingFacade AS SettingManager;

if (!function_exists('setting')) {
    /**
     * Get the value of a Setting.
     *
     * @param mixed $settingName Get the value of a Setting by its name
     * @param string $defaultValue Return a default value if no value was found
     * @return mixed
     */
    function setting(mixed $settingName, string $defaultValue = null): mixed
    {
        return SettingManager::get($settingName, $defaultValue);
    }
}
