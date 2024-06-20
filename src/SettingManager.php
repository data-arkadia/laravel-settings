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
            $value = $this->getFromCache($settingName);

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
     * @param string $settingName The name of the setting of which a value is requested
     * @return array
     */
    private function getFromCache(string $settingName): array
    {
        $valueFromCache = (array) Cache::get($settingName);

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

            $settingCategory = SettingCategory::where('slug', $categorySlug)
                ->first();
            $setting = $settingCategory->settings
                ->where('slug', $settingNameSlug)
                ->first();
            $settingValue = $setting->setting_value->value;
        } finally {
            if ($settingCategory == null OR $setting == null) {
                throw new Exception('Setting Category or Setting does not exist: '.$settingName);
            }

            $referenceableSettingValue = $this->createReferenceableSettingValue(
                $setting->data_type,
                $settingValue
            );

            $this->referenceableSettingValueCacher(
                $settingName,
                $referenceableSettingValue
            );

            return $referenceableSettingValue;
        }
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
     * @param string $settingName The name of the setting which will be the Cache key
     * @param array $referenceableSettingValue The formatted setting that should be cached
     * @return void
     */
    private function referenceableSettingValueCacher(string $settingName, array $referenceableSettingValue): void
    {
        Cache::put($settingName, $referenceableSettingValue);
    }

    /**
     * Wrapper for taking raw setting data to format
     * to a referenceable setting and storing it in Cache.
     *
     * @param string $settingName The name of the setting which will be the Cache key
     * @param string $valueDataType The data type of the setting's value
     * @param mixed $settingValue The value of the setting
     * @return void
     */
    public function cacheReferenceableSettingValue(string $settingName, string $valueDataType, mixed $settingValue): void
    {
        $referenceableSettingValue = $this->createReferenceableSettingValue(
            $valueDataType,
            $settingValue
        );

        $this->referenceableSettingValueCacher(
            $settingName,
            $referenceableSettingValue
        );
    }
}
