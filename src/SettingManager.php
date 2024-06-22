<?php

namespace DataArkadia\LaravelSettings;

use Exception;
use Illuminate\Support\Facades\Cache;
use DataArkadia\LaravelSettings\Models\SettingCategory;

class SettingManager
{
    /**
     * Get the value of a Setting.
     *
     * @param string $settingName Get the value of a Setting by its name
     * @param mixed $defaultValue Return a default value if no value was found
     * @return mixed
     */
    public function get(string $settingName, mixed $defaultValue = null): mixed
    {
        $valueToReturn = null;

        try {
            $value = null;

            if (config('laravel-settings.useCache')) {
                $cacheKey = $this->createCacheKey($settingName);
                $value = $this->getFromCache($cacheKey);
            }

            if ($value == null) {
                $value = $this->getFromDatabase($settingName);
            }

            if ($value['value'] !== null AND !in_array($value['valueDataType'], ['tw-color'])) {
                settype($value['value'], $value['valueDataType']);
            }

            $valueToReturn = $value['value'];
        } finally {
            if ($valueToReturn === null) {
                $valueToReturn = $defaultValue;
            }

            return $valueToReturn;
        }
    }

    /**
     * Get the value of a setting from the cache.
     *
     * @param string $cacheKey The key to retrieve the setting from Cache
     * @return array|null
     */
    private function getFromCache(string $cacheKey): ?array
    {
        $valueFromCache = (array) Cache::get($cacheKey);

        if (empty($valueFromCache)) {
            return null;
        }

        return $valueFromCache;
    }

    /**
     * Get the value of a setting from the database.
     *
     * @param string $settingName The name of the setting of which a value is requested
     * @return array
     */
    private function getFromDatabase(string $settingName): array
    {
        $settingCategory = null;
        $setting = null;
        $settingValue = null;

        try {
            $settingNameParts = explode('.', $settingName);
            $categorySlug = $settingNameParts[0];
            $settingNameSlug = $settingNameParts[1];

            // Get setting category
            $settingCategory = SettingCategory::where('slug', $categorySlug)
                ->first();

            // Get setting
            $setting = $settingCategory->settings
                ->where('slug', $settingNameSlug)
                ->first();

            // Get setting value
            if (config('laravel-settings.storeSettingValuesPerUser')) {
                $settingValue = $setting->setting_value()
                    ->where('user_id', auth()->id())
                    ->first()
                    ->value;
            } else {
                $settingValue = $setting->setting_value->value;
            }
        } finally {
            if ($settingCategory == null OR $setting == null) {
                throw new Exception('Setting Category or Setting does not exist: '.$settingName);
            }

            $cacheKey = $this->createCacheKey($settingName);
            $referenceableSettingValue = $this->createReferenceableSettingValue(
                $setting->data_type,
                $settingValue
            );

            $this->referenceableSettingValueCacher(
                $cacheKey,
                $referenceableSettingValue
            );

            return $referenceableSettingValue;
        }
    }

    /**
     * Create name for cache key.
     *
     * @param string $settingName The name of the setting
     * @return string
     */
    public function createCacheKey(string $settingName): string
    {
        if (config('laravel-settings.storeSettingValuesPerUser')) {
            $settingName = auth()->id().'.'.$settingName;
        }

        return $settingName;
    }

    /**
     * Format a setting's value and its associated
     * metadata so that it can be stored in Cache.
     *
     * @param string $valueDataType The data type of the setting's value
     * @param mixed $settingValue The value of the setting
     * @return array
     */
    public function createReferenceableSettingValue(string $valueDataType, mixed $settingValue): array
    {
        $payloadForCache = [
            'valueDataType' => $valueDataType,
            'value' => $settingValue,
        ];

        return $payloadForCache;
    }

    /**
     * Wrapper for storing a referenceable setting in Cache.
     *
     * @param string $cacheKey The key to store the setting under in Cache
     * @param array $referenceableSettingValue The formatted setting that should be cached
     * @return void
     */
    public function referenceableSettingValueCacher(string $cacheKey, array $referenceableSettingValue): void
    {
        Cache::put($cacheKey, $referenceableSettingValue);
    }
}
