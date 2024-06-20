<?php

namespace DataArkadia\LaravelSettings\Models;

use DataArkadia\LaravelSettings\Facades\SettingFacade AS SettingManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'setting_id',
        'value',
    ];

    /**
     * Inverse one-to-one to Setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    /**
     * Capability to store this value
     * in Cache with its appropriate key.
     *
     * @return void
     */
    public function storeInCache(): void
    {
        $setting = $this->setting;
        $settingCategory = $setting->setting_category;

        $settingName = $settingCategory->slug.'.'.$setting->slug;
        $settingValue = $this->value;

        SettingManager::cacheReferenceableSettingValue(
            $settingName,
            $setting->data_type,
            $settingValue
        );
    }
}
