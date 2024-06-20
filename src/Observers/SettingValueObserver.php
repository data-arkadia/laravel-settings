<?php

namespace DataArkadia\LaravelSettings\Observers;

use DataArkadia\LaravelSettings\Models\SettingValue;

class SettingValueObserver
{
    /**
     * Handle the SettingValue "saved" event.
     *
     * @param  \App\Models\SettingValue  $settingValue
     * @return void
     */
    public function saved(SettingValue $settingValue): void
    {
        if (request()->input('setting_value_value') == null) {
            $settingValue->delete();
        }

        $settingValue->storeInCache();
    }
}
