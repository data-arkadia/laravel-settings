<?php

namespace DataArkadia\LaravelSettings\Models;

use DataArkadia\LaravelSettings\Events\SluggableSaving;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saving' => SluggableSaving::class,
    ];

    /**
     * Get the Settings under a SettingCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    private function getWithUnconfiguredSettingsQuery(string $slug, string $withItemsOrCount)
    {
        $category = $this->where('slug', $slug)
            ->{$withItemsOrCount}(['settings' => function ($query) {
                $query->where('required', true)
                    ->doesntHave('setting_value');
            }])
            ->first();

        return $category;
    }

    public static function getUnconfiguredSettings(string $slug)
    {
        $category = (new self)->getWithUnconfiguredSettingsQuery($slug, 'with');
        $settings = $category->settings;

        return $settings;
    }

    public static function totalUnconfiguredSettings(string $slug)
    {
        $category = (new self)->getWithUnconfiguredSettingsQuery($slug, 'withCount');

        if ($category == null) {
            return 0;
        }

        $settingsCount = $category->settings_count;

        return $settingsCount;
    }
}
