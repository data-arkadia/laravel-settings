<?php

namespace DataArkadia\LaravelSettings\Observers;

use SettingManager;
use Illuminate\Support\Facades\Cache;
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
            // Delete the setting from the cache if the value is null
            $setting = $settingValue->setting;
            $settingCategory = $setting->setting_category;
            $settingName = sprintf('%s.%s', $settingCategory->slug, $setting->slug);
            $cacheKey = SettingManager::createCacheKey($settingName);
            Cache::forget($cacheKey);

            $settingValue->delete();
        }

        $settingValue->storeInCache();
    }
}
