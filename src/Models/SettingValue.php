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
        'user_id',
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
     * Scope a query to only include setting
     * values that belong to the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeForUser($query, $user): void
    {
        $query->where('user_id', $user->id);
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
        $settingName = sprintf('%s.%s', $settingCategory->slug, $setting->slug);
        $settingValue = $this->value;
        $cacheKey = SettingManager::createCacheKey($settingName);
        $referenceableSettingValue = SettingManager::createReferenceableSettingValue(
            $setting->data_type,
            $settingValue
        );

        SettingManager::referenceableSettingValueCacher(
            $cacheKey,
            $referenceableSettingValue
        );
    }
}
